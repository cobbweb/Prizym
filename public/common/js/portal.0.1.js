/* 
 * jQuery.portal v0.1.0
 *
 * Copyright (c) 2010 Joshua Faulkenberry
 * Dual licensed under the MIT and GPL licenses.
 *
 * Date: 2010-11-22 18:47:30 -0800 (Mon, 22 Nov 2010) 
 * Revision: 12 
 */

(function($) {

   $.fn.portal = function(id, options) {
      var conf = {
         title: "",
         content: "",
         closer: true,
         hider: true,
         min: false,
         settings: false,
         detachable: true,
         floating: false,
         width: 300,
         modal: true
      };
      $.extend(conf, options);
   
      var prtlt = $('<div>').attr("id", id).addClass("portlet ui-widget ui-widget-content ui-helper-clearfix sortable").append(
         $('<div>').addClass("portlet-header ui-state-default").append(
            $('<span>').addClass("title").text(conf.title)      
         )
      ).append(
         $('<fieldset>').addClass("portlet-content").html(conf.content)
      ).data("container", $(this));
      //Add the detach button
      if (conf.detachable) {
         prtlt.find(".portlet-header").prepend(
            $('<input/>').addClass("ui-icon ui-icon-circle-arrow-n portlet-detach").attr({
               "type": "button",
               "title": "Detach"
            })
         );
      }
      //Add the settings button
      if (conf.settings) {
         prtlt.find(".portlet-header").prepend(
            $('<input/>').addClass("ui-icon ui-icon-circle-triangle-s portlet-config").attr({
               "type": "button",
               "title": conf.settings.title
            }).popMenu(id+"_menu", {menu:conf.settings.menu})
         );
      }
      //Add the hider button
      if (conf.hider) {
         prtlt.find(".portlet-header").prepend(
            $('<input/>').addClass("ui-icon ui-icon-circle-minus portlet-min-max").attr({
               "type": "button",
               "title": "Minimize"
            })
         );
         if(conf.min) {
            prtlt.data("filler", conf.min)
         }
      }
      //Add the closer button
      if (conf.closer) {
         prtlt.find(".portlet-header").prepend(
            $('<input/>').addClass("ui-icon ui-icon-circle-close portlet-closer").attr({
               "type": "button",
               "title": "Close"
            })
         );
      }
         
      return this.each(function() {
         prtlt.hide();

       if(conf.floating) {
         if(conf.detachable) {
             prtlt.find(".portlet-header input.portlet-detach").attr("title", "Attach").removeClass("ui-icon-circle-arrow-n").addClass("ui-icon-circle-arrow-s").data("detached", 1);
         } 
         prtlt.css("z-index", "1001").find(".portlet-content").html(
            $("<div>").html(
               prtlt.find(".portlet-content").html()
            ).addClass("content")
         );
         $.portal.detach(prtlt, conf);
       }
      else {
         $(this).append(prtlt);
      }
      if(conf.min) {
         prtlt.find("input.portlet-min-max").data("go", false).click(); 
         prtlt.find(".portlet-content").hide(); 
      }
      else {
         prtlt.find("input.portlet-min-max").data("go", true);
      }
      prtlt.show();
      });
   };
   
   $.portal = function(id, conf) {
      conf = conf || {};
      conf.floating = true;
      $(document.body).portal(id, conf);
   };
   
   $.portal.detach = function(prtlt, conf) {
      var conf = conf || {};
      conf.width = conf.width || $(prtlt).width();
      conf.modal = conf.modal || false;
      prtlt.appendTo(document.body).removeClass("sortable").addClass("popup").draggable({
         handle:prtlt.find(".portlet-header")
      }).resizable({  
         minWidth:150,
         minHeight:70,
			alsoResize:prtlt.find(".portlet-content")
      }).css({  
         "width": conf.width + "px",
         "position": "absolute",
         "z-index": "101"
      }).data("popHeight", "");
      if (conf.modal) {
         prtlt.css("z-index", "1001");
         $.portal.modal();
      }
		
      var top = document.body.scrollTop + (document.body.clientHeight/2 - prtlt.outerHeight()/2),
          lft = document.body.scrollLeft + (document.body.clientWidth/2 - prtlt.outerWidth()/2); 
      if(prtlt.outerHeight() > document.body.clientHeight) top = 0;   
      if(prtlt.outerWidth() > document.body.clientWidth) lft = 0;   
      
      prtlt.css({   
         "top": top,  
         "left": lft  
      });
     if (prtlt.parent().data("min")) {
       prtlt.find(".ui-resizable-handle").toggle();
     }
   };
   
   $.portal.attach = function(prtlt) {
      prtlt.data("container").prepend(prtlt);
      $(".modal").remove();
      $(prtlt).addClass("sortable").removeClass("popup").draggable("destroy").resizable("destroy").css({  
         "width": "",
         "position": "",
         "z-index": "5", 
         "height": "" 
      });
      $(prtlt).find(".portlet-content").css({  
         "width": "",
         "height": "" 
      });
   };
   
   $.portal.modal = function() {
      $("<div class='modal' />").css({
         "height": $(document).height(),
         "z-index": "1000"
      }).appendTo(document.body);
   }
   
   $.portal.remember = function(callback) {
      $.portal.layout = {};
      $(".portalBox").each(function(x, cont) {
			if (this.id) {
            var id = this.id;
				$.portal.layout[id] = {};
				$(cont).find(".sortable").each(function(y, prt) {
				   if ($(prt).find(".portlet").attr("id")) {
						$.portal.layout[id][$(prt).find(".portlet").attr("id")] = {
							minimized: $(prt).data("min") ? true : false
						};
					}
				});
			}       
      });
      if($.portal.memCallBack) {
         $.portal.memCallBack($.portal.layout, callback);
      }
      else if(callback) {
         callback($.portal.layout);
      }
   }
   
   $(document).ready(function() {
      
      $("div.portalBox").sortable({
         connectWith: '.portalBox',
         items: '.sortable',
         handle: '.portlet-header',
         placeholder: 'placer',
         forcePlaceholderSize: true,
         forceHelperSize:true,
         revert: true,
         dropOnEmpty:true,
         stop: function(e, ui) { 
			   ui.item.data("container", $(e.target))
            $.portal.remember();
            if($.portal.onStop) {
               $.portal.onStop();
            }
         }
      });
      
   });
   
})(jQuery);


/* Portal behaviors */


$(document).resize(function(){
   $("div.modal").css({
      "height": $(document).height(),
      "width": $(document).width()
   });
}).mousedown(function() {
      $(".ui-icon-triangle-1-s").removeClass("ui-icon-triangle-1-s").addClass("ui-icon-circle-triangle-s");
});

$(".portlet-header").live("mouseover", function() {
   $(this).removeClass("ui-state-default").addClass("ui-state-hover");
}).live("mouseout", function() {
   $(this).removeClass("ui-state-hover").addClass("ui-state-default");
}).live("mousedown", function() {
   $(this).removeClass("ui-state-default").addClass("ui-state-active");
}).live("mouseup", function() {
   $(this).removeClass("ui-state-active").addClass("ui-state-default");
});

$("input.portlet-closer").live("click", function() {
   $(this).parents(".portlet").remove();
   $(".modal").remove();
   $.portal.remember();
   return false;
});

$("input.portlet-min-max").live("click", function() {
	var $this = $(this),
       prt = $this.parents(".sortable"),
       pop = $this.parents(".popup"),
		 flr = $this.parents(".portlet").data("filler");
   if($this.attr("title") == "Maximize") {
      if(flr) {
         flr($this.parents(".portlet").attr("id"));
         $this.parents(".portlet").data("filler", false);
      }
		if(pop.length) pop.height(pop.data("popHeight")).find(".ui-resizable-handle").show();
		$this.attr("title", "Minimize").addClass("ui-icon-circle-minus").removeClass("ui-icon-circle-plus");
		$this.parents(".portlet").find(".portlet-content").slideDown();
      prt.data("min", false);
   }
   else {
		if(pop.length) pop.data("popHeight", pop.height()).css("height", "").find(".ui-resizable-handle").hide();
		$this.attr("title", "Maximize").removeClass("ui-icon-circle-minus").addClass("ui-icon-circle-plus");
		$this.parents(".portlet").find(".portlet-content").slideUp();
		prt.data("min", true);
   }
   if ($this.data("go")) {
      $.portal.remember();
   }
   else {
      $this.data("go", true);
   }
});

$("input.portlet-config").live("click", function() {
   $(this).removeClass("ui-icon-circle-triangle-s").addClass("ui-icon-triangle-1-s");
});

$("input.portlet-detach").live("click", function() {
   if(!$(this).data("detached")) {
      $.portal.detach(
		   $(this).data("detached", true).attr({
				"title": "Attach"
			}).removeClass("ui-icon-circle-arrow-n").addClass("ui-icon-circle-arrow-s").parents(".portlet")
		);
   }
   else {
      $.portal.attach(
		   $(this).data("detached", false).attr({
				"title": "Detach"
			}).removeClass("ui-icon-circle-arrow-s").addClass("ui-icon-circle-arrow-n").parents(".portlet")
		);
   }   
});
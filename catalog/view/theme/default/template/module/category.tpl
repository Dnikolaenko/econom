<div class="box">
  <div class="top"><img src="catalog/view/theme/default/image/icon_category.png" alt="" /><?php echo $heading_title; ?></div>
  <?php /*<div id="category" class="middle"><?php echo $category; ?></div> */ ?>
  <div class="middle" onclick="tree_toggle(arguments[0])"><?php echo $category['html']; ?></div>
  <div class="bottom">&nbsp;</div>
  <script type="text/javascript"><!--
    $(function () {
      $('.cat_tip').tooltip({
        track: true,
        delay: 150,
        showURL: false,
        showBody: " |-| ",
        fade: 500,
        extraClass: 'cat_width',
        bodyHandler: function() {
           return $('#cat_id' + $(this).attr("cat_id")).html();
         }
      });
    });

    function tree_toggle(event) {
            event = event || window.event
            var clickedElem = event.target || event.srcElement

            if (!hasClass(clickedElem, 'expand')) {
                    return // клик не там
            }

            // Node, на который кликнули
            var node = clickedElem.parentNode
            if (hasClass(node, 'leaf')) {
                    return // клик на листе
            }

            // определить новый класс для узла
            var newClass = hasClass(node, 'expanded') ? 'collapsed' : 'expanded'
            // заменить текущий класс на newClass
            // регексп находит отдельно стоящий open|close и меняет на newClass
            var re =  /(^|\s)(expanded|collapsed)(\s|$)/
            node.className = node.className.replace(re, '$1'+newClass+'$3')
            
            $("#content > .middle").css("min-height", $("#column_left").height() - 10 + "px")
    }


    function hasClass(elem, className) {
            return new RegExp("(^|\\s)"+className+"(\\s|$)").test(elem.className)
    }
  //--></script>
</div>

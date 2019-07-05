(function(window) {

    'use strict';

    function typeRowsLayoutModeDefinition(LayoutMode) {
        
        
        
        
        var TypeRows = LayoutMode.create('typeRows');

        /**
         * Called every time the layout if reevaluated
         */
        TypeRows.prototype._resetLayout = function() {
            
            var paras = document.getElementsByClassName('separator');
            while(paras[0]) { paras[0].parentNode.removeChild(paras[0]); }


            this.typeRows = {
                x : 0,
                y : 0,
                height : 0,
                currentType : null
            };

            this.getSize()
            var containerWidth = this.size.innerWidth;

            

            // // Get column width and gutter size
            // this.getColumnWidth();
            // this._getMeasurement('gutter', 'outerHeight');
            // this.getSize()

            // // Add gutter and adjust column width/count accordingly
            // var gutter = this.options.gutter || 0;
            // var containerWidth = this.size.innerWidth;
            // this.columnWidth += gutter;
            // var cols = this.cols = Math.floor((containerWidth + gutter) / this.columnWidth) || 1;

            // // Initialize column heights to zero
            // this.columnHeights = [];
            // while (cols--) this.columnHeights.push(0);
            // this.currentColumn = 0;
        };

        /**
         * Determines the position for each consecutive element
         * @param item Item to be positioned.
         * @returns {{x: number, y: number}}
         */
        TypeRows.prototype._getItemLayoutPosition = function(item) {

            var props = this.typeRows;
            var containerWidth = this.size.width;
            var sortBy = this.isotope.options.sortBy;

            //console.log("containerWidth", containerWidth);

            // Determine item size
            item.getSize();
            var atomW = item.size.outerWidth;
            var atomH = item.size.outerHeight;
            // get category value for separating headline name
            var dataType = item.element.getAttribute("data-type");
            var type = dataType, x, y;
            
            if ( type !== props.currentType && type !== null) {

                // set separating headline
                var newNode = document.createElement("h3");
                newNode.textContent = type;
                newNode.style.top = props.height + "px";
                newNode.classList.add('separator');

                // add ID as plain string
                var plainType = type.replace(/\W/g,'_');
                newNode.setAttribute("id", plainType);

                // add separating headline
                var parentDiv = item.element.parentNode;
                var insertedNode = parentDiv.insertBefore(newNode, item.element);
              
                // new type, new row
                props.x = 0;

                // calculate grid including separating headline
                props.y = props.height + newNode.offsetHeight;
                props.currentType = type;

            } else if ( props.x !== 0 && atomW + props.x > containerWidth ) {
                // if this element cannot fit in the current row
                props.x = 0;
                props.y = props.height;
                
            } 
      
            props.height = Math.max( props.y + atomH, props.height );

            var position = {
                x: props.x,
                y: props.y
            };

            props.x += atomW;

            //console.log("position", position);

            return position;


            // // Determine item size
            // item.getSize();
            // var itemWidth = item.size.outerWidth, itemHeight = item.size.outerHeight;
            // var itemCols = Math.min(this.cols, Math.ceil(itemWidth / this.columnWidth));

            // // See if item still fits in current column; otherwise go back to column 0
            // if (this.currentColumn + itemCols > this.cols) {
            //     this.currentColumn = 0;
            // }

            // // Find longest column as use length
            // var maxHeight = 0;
            // for (var offset = 0; offset < itemCols; offset++) {
            //     maxHeight = Math.max(maxHeight, this.columnHeights[this.currentColumn + offset]);
            // }

            // // Update column heights with new height
            // var newColumnHeight = maxHeight + itemHeight;
            // for (offset = 0; offset < itemCols; offset++) {
            //     this.columnHeights[this.currentColumn + offset] = newColumnHeight;
            // }

            // // Got all we need
            // var position = {
            //     x: this.currentColumn * this.columnWidth,
            //     y: maxHeight
            // };

            // // Update column pointer
            // this.currentColumn += itemCols;
            // if (this.currentColumn > this.cols) {
            //     this.currentColumn = 0;
            // }

            // return position;
        };

        /**
         * Calculates the size of the container
         * @returns {{height: number}}
         */
        TypeRows.prototype._getContainerSize = function() {
            console.log("this.typeRows", this.typeRows);
            return {
                height: this.typeRows.height
            }
        };

    }

    // Load definition, either synchronously or asynchronously
    if ('function' === typeof define && define.amd) {
        // Use Asynchronous Module Definition (AMD)
        define(
            [   // Dependencies
                'isotope/js/layout-mode'
            ],
            typeRowsLayoutModeDefinition
        )
    } else {
        // Load synchronously
        typeRowsLayoutModeDefinition(
            (window.Isotope.LayoutMode)
        );
    }

})(window);

/*
  // categoryRows custom layout mode
  $.extend( window.Isotope.prototype, {
  
    _categoryRowsReset : function() {
      this.categoryRows = {
        x : 0,
        y : 0,
        height : 0,
        currentCategory : null
      };
    },
  
    _categoryRowsLayout : function( $elems ) {
      var instance = this,
          containerWidth = this.element.width(),
          sortBy = this.options.sortBy,
          props = this.categoryRows;
      
      $elems.each( function() {
        var $this = $(this),
            atomW = $this.outerWidth(true),
            atomH = $this.outerHeight(true),
            category = $.data( this, 'isotope-sort-data' )[ sortBy ],
            x, y;
      
        if ( category !== props.currentCategory ) {
          // new category, new row
          props.x = 0;
          props.height += props.currentCategory ? instance.options.categoryRows.gutter : 0;
          props.y = props.height;
          props.currentCategory = category;
        } else if ( props.x !== 0 && atomW + props.x > containerWidth ) {
          // if this element cannot fit in the current row
          props.x = 0;
          props.y = props.height;
        } 
      
        // position the atom
        instance._pushPosition( $this, props.x, props.y );
  
        props.height = Math.max( props.y + atomH, props.height );
        props.x += atomW;
  
      });
    },
  
    _categoryRowsGetContainerSize : function () {
      return { height : this.categoryRows.height };
    },
  
    _categoryRowsResizeChanged : function() {
      return true;
    }
  
  });

  // (function(window) {
    
  //   var $container = $('#container');
    
    
  //     // add randomish size classes
  //     $container.find('.element').each(function(){
  //       var $this = $(this),
  //           number = parseInt( $this.find('.number').text(), 10 );
  //       if ( number % 7 % 2 === 1 ) {
  //         $this.addClass('width2');
  //       }
  //       if ( number % 3 === 0 ) {
  //         $this.addClass('height2');
  //       }
  //     });
    
  //   $container.isotope({
  //     itemSelector : '.element',
  //     layoutMode : 'categoryRows',
  //     categoryRows : {
  //       gutter : 20
  //     },
  //     getSortData : {
  //       category : function( $elem ) {
  //         return $elem.attr('data-category');
  //       }
  //     },
  //     sortBy: 'category'
  //   });

    
  //     var $optionSets = $('#options .option-set'),
  //         $optionLinks = $optionSets.find('a');

  //     $optionLinks.click(function(){
  //       var $this = $(this);
  //       // don't proceed if already selected
  //       if ( $this.hasClass('selected') ) {
  //         return false;
  //       }
  //       var $optionSet = $this.parents('.option-set');
  //       $optionSet.find('.selected').removeClass('selected');
  //       $this.addClass('selected');
  
  //       // make option object dynamically, i.e. { filter: '.my-filter-class' }
  //       var options = {},
  //           key = $optionSet.attr('data-option-key'),
  //           value = $this.attr('data-option-value');
  //       // parse 'false' as false boolean
  //       value = value === 'false' ? false : value;
  //       options[ key ] = value;
  //       if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
  //         // changes in layout modes need extra logic
  //         changeLayoutMode( $this, options )
  //       } else {
  //         // otherwise, apply new options
  //         $container.isotope( options );
  //       }
        
  //       return false;
  //     });


    
  //     $('#insert a').click(function(){
  //       var $newEls = $( fakeElement.getGroup() );
  //       $container.isotope( 'insert', $newEls );

  //       return false;
  //     });

  //     $('#append a').click(function(){
  //       var $newEls = $( fakeElement.getGroup() );
  //       $container.append( $newEls ).isotope( 'appended', $newEls );

  //       return false;
  //     });


  //   // toggle variable sizes of all elements
  //   $('#toggle-sizes').find('a').click(function(){
  //     $container
  //       .toggleClass('variable-sizes')
  //       .isotope('reLayout');
  //     return false;
  //   });

  // });
  */
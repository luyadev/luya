/**
 * @file
 * Lazyloading
 */

(function ($) {

  const lazyload = {

      debug: false,
      initialized: false,

      // Used to identify all lazyload images
      // including background images
      imageSelector: '.js-lazyimage',
      // The image class applied to all regular
      // <img> lazyload images
      imageClass: 'lazyimage',
      // The wrapper class around the lazyimage
      // used for positioning and
      // aspect ratio
      imageWrapperClass: 'lazyimage-wrapper',
      // The placeholder div that includes the
      // loader html
      placeholderClass: 'lazyimage-placeholder',
      // The loader html, customize according
      // to your needs
      loaderHtml: '<div class="loader"></div>',

      images: [],
      observer: null,
      observerOptions: {
          root: document.getElementsByTagName('body')[0],
          rootMargin: '200px 0px 200px',
          threshold: 0.01
      },

      latestId: 0,

      // Return a new id based on
      // latestId
      getId() {
          return this.latestId += 1
      },

      /**
       * Returns the image object from the
       * images array based on the image id
       * 
       * @param integer id 
       * @returns object
       */
      getImageById(id) {
          return this.images.find(image => image.id === id)
      },
      
      /**
       * Collects all images on page
       * and writes them in the images array
       */
      collectImages() {
          const context = this
          $(this.imageSelector).each(function() {
              if ($(this).data('lazy-id') === undefined) {
                  const id = context.getId()
                  $(this)
                      .data('lazy-id', id)
                      .addClass(`${context.imageClass}-${id}`)

                  context.images.push({
                      id,
                      el: this,
                      asBackground: !!$(this).data('as-background'),
                      replacePlaceholder: !!$(this).data('replace-placeholder'),
                      isLoaded: false,
                      isObserved: false
                  })
              }
          })

          this.log('Images', this.images)
      },

      observeImages() {
          if (!this.observer) {
              this.initObserver()
          }

          for (const image of this.images) {
              if (!image.isObserved && !image.isLoaded) {
                  this.observer.observe(image.el)
                  image.isObserved = true
              }
          }
      },

      imageIntersects(entries) {
          for (const entry of entries) {
              if (entry.isIntersecting) {
                  this.observer.unobserve(entry.target)
                  this.loadImage(this.getImageById($(entry.target).data('lazy-id')))
              }
          }
      },

      loadImage(image) {
          const context = this

          this.log('Image loading:', { id: image.id, image })

          $(document).trigger('lazyimage-loading', {
              image
          })

          const $loadImage = $('<img/>')

          // If the image was loaded successfully
          $loadImage.on('load', function () {
              image.isLoaded = true

              const $el = $(image.el)

              if (image.asBackground) {
                  // If the image is a background-image we need to update the
                  // original div with the background image url
                  $el.css({
                      backgroundImage: 'url(' + $el.data('src') + ')'
                  })
              } else {
                  // Set the src value
                  // apply the "loaded" class
                  
                  if (!image.replacePlaceholder) {
                      $el
                          .attr('src', $el.data('src'))
                          .addClass('loaded')
                          .parent(`.${context.imageWrapperClass}`)
                          .addClass('loaded')
                  } else {
                      const $wrapper = $el.parent(`.${context.imageWrapperClass}`)
                      $wrapper
                          .replaceWith(
                              $el
                                  .removeClass('lazyimage')
                                  .addClass('loaded lazy-image')
                                  .attr('src', $el.data('src'))
                          )
                  }
              }

              context.log('Image loaded:', { id: image.id, image })

              // Trigger a success event
              $(document).trigger("lazyimage-loaded", {
                  type: 'success',
                  image
              })
          })

          // If the image can't be loaded
          $loadImage.on('error', function () {
              context.log('Image load error:', { id: image.id, image })

              // Trigger a error event
              $(document).trigger("lazyimage-loaded", {
                  type: 'error',
                  image
              })
          })

          // Load the image
          $loadImage.attr('src', $(image.el).data('src'))
      },

      initObserver() {
          this.observer = new IntersectionObserver(this.imageIntersects.bind(this), this.observerOptions)
      },

      init(options) {
          this.log('Init, options:', options || {})

          // Extend the lazyload object options
          for (const option in options) {
              if (this.hasOwnProperty(option) && typeof this[option] !== 'function') {
                  if (typeof this[option] === 'object') {
                      this[option] = $.extend(this[option], options[option])
                  } else {
                      this[option] = options[option]
                  }
              }
          }

          // If not initialized already, do so
          if (!this.initialized) {
              this.collectImages()
              this.initObserver()
              this.observeImages()
          }

          this.initialized = true
      },

      log() {
          if (this.debug) {
              console.log(...arguments)
          }
      }
  }

  $.lazyLoad = function (options) {
      if(typeof options === 'string') {
          switch(options) {
              case 'refetchElements':
              case 'collectImages':
                  lazyload.collectImages()
                  lazyload.observeImages()
              break;
          }
      } else {
          lazyload.init(options)
          return this
      }
  }

}(jQuery))
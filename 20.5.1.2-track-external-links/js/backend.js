window.outgoing_links_class = function () {
  'use strict';

  this.current_page   = 1;
  this.constants      = null;

  /**
   * Initializing.
   *
   * @since 0.3.0
   */
  this.init = function () {
    var self = this;

    /* Waiting for the DOM to be loaded */
    document.addEventListener( 'DOMContentLoaded', function () {
      self.add_pagination_event_handlers();
    } );

    this.find_current_page_from_url();

    this.constants = window.tel_script_constants;
  };


  /**
   * Reads the `per_page` Parameter from the current URL.
   */
  this.find_current_page_from_url = function () {

    var paged_r = window.location.search.match( new RegExp( 'paged=([0-9]+)' ) );

    if ( null === paged_r ) {
      return;
    }

    if ( paged_r[1] !== undefined ) {
      this.current_page = parseInt( paged_r[1] );
    }
  };


  /**
   * Add Event listeners to pagination links.
   * @since 0.3.0
   */
  this.add_pagination_event_handlers = function () {
    var self             = this,
        i,
        j,
        links,
        pagination_links = document.getElementsByClassName( 'pagination-links' );

    if ( pagination_links.length <= 0 ) {
      return;
    }

    for ( j = 0; j < pagination_links.length; j ++ ) {
      links = pagination_links[j].getElementsByTagName( 'a' );

      if ( links.length <= 0 ) {
        continue;
      }

      for ( i = 0; i < links.length; i ++ ) {
        links[i].addEventListener( 'click', function ( e ) {
          e.preventDefault();
          self.on_click_pagination( this );
        } );
      }
    }

  };


  /**
   * Handles onClick events for pagination links.
   *
   * @since 0.3.0
   */
  this.on_click_pagination = function ( el ) {

    var args = {
      'per_page': this.get_per_page(),
    };

    var max_pages = Math.ceil( this.constants.total_records / Math.max( args.per_page, 1 ) );

    if ( el.classList.contains( 'first-page' ) ) {
      args.page = 1;
    }
    else if ( el.classList.contains( 'last-page' ) ) {
      args.page = max_pages;
    }
    else if ( el.classList.contains( 'prev-page' ) ) {
      args.page = Math.max( this.current_page - 1, 1 );
    }
    else if ( el.classList.contains( 'next-page' ) ) {
      args.page = Math.max( this.current_page + 1, max_pages );
    }

  };


  /**
   * Gets the 'per_page' parameter from the screen options.
   *
   * @since 0.3.0
   */
  this.get_per_page = function () {
    return parseInt( document.getElementById( 'links_per_page' ).value );
  };

};

window.outgoing_links = new window.outgoing_links_class();
window.outgoing_links.init();
window.outgoing_links_class = function () {
  'use strict';

  this.current_page = 1;
  this.constants    = null;

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

    wp.api.loadPromise.done( function () {
      self.init_backbone();
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
      args.page = Math.min( this.current_page + 1, max_pages );
    }

    this.load_links( args );
  };


  /**
   * Gets the 'per_page' parameter from the screen options.
   *
   * @since 0.3.0
   */
  this.get_per_page = function () {
    return parseInt( document.getElementById( 'links_per_page' ).value );
  };


  /**
   * Loads the links.
   *
   * @since 0.3.0
   */
  this.load_links = function ( args ) {
    var self = this;

    var links_collection = new wp.api.collections.OutgoingLinks();

    links_collection.fetch( {'data': args} ).done( function ( links ) {
      self.update_table( links );
      self.current_page = args.page;
      self.update_pagination_nav( args.page );
    } );
  };


  /**
   * Extend BackboneJS for the outgoing links.
   *
   * @since 0.3.0
   */
  this.init_backbone = function () {

    var args           = wpApiSettings;
    args.versionString = 'tel/v1/';

    wp.api.init( args );
  };


  /**
   * Replaces the old table rows with the new ones.
   *
   * @since 0.3.0
   *
   * @param links
   */
  this.update_table = function ( links ) {
    var table,
        rows = '',
        row,
        link;

    table = document.getElementById( 'the-list' );

    /* remove previous links from DOM */
    table.innerHTML = '';


    for ( var i = 0; i < links.length; i ++ ) {
      link = links[i];

      row = tel_single_row_template.replace( '%%id%%', link.id );
      row = row.replace( new RegExp( '%%title%%', 'g' ), link.title );
      row = row.replace( new RegExp( '%%slug%%', 'g' ), link.slug );
      row = row.replace( new RegExp( '%%count%%', 'g' ), link.count );
      row = row.replace( new RegExp( 'http://%%link%%', 'g' ), link.link );
      row = row.replace( new RegExp( 'data-id="0"', 'g' ), 'data-id="' + link.id + '"' );

      rows += row;
    }

    table.innerHTML = rows;
  };


  /**
   * Updates the pagination navigation.
   *
   * @since 0.3.0
   *
   * @param page_number
   */
  this.update_pagination_nav = function ( page_number ) {
    var pagination_links,
        j,
        html,
        max_pages,
        paging_text,
        paging_input;

    var pagination_links_collection = document.getElementsByClassName( 'pagination-links' );

    if ( pagination_links_collection.length <= 0 ) {
      return;
    }

    for ( j = 0; j < pagination_links_collection.length; j ++ ) {
      html             = '';
      pagination_links = pagination_links_collection[j];

      /* « and ‹ Button */
      if ( page_number <= 1 ) {
        html += '<span class="tablenav-pages-navspan">«</span> ';
        html += '<span class="tablenav-pages-navspan">‹</span> ';
      }
      else {
        html += '<a class="first-page" href="#"><span>«</span></a> ';
        html += '<a class="prev-page" href="#"><span>‹</span></a> ';
      }

      paging_text = pagination_links.getElementsByClassName( 'current-page' );

      if ( paging_text.length ) {
        paging_text[0].setAttribute( 'value', page_number );
      }

      paging_input = pagination_links.getElementsByClassName( 'paging-input' );

      if ( paging_input.length ) {
        html += paging_input[0].outerHTML.replace( new RegExp( '([0-9])+ ' ), page_number + ' ' ) + ' ';
      }

      max_pages = Math.ceil( this.constants.total_records / Math.max( this.get_per_page(), 1 ) );

      if ( page_number >= max_pages ) {
        html += '<span class="tablenav-pages-navspan">›</span> ';
        html += '<span class="tablenav-pages-navspan">»</span> ';
      }
      else {
        html += '<a class="next-page" href="#"><span>›</span></a> ';
        html += '<a class="last-page" href="#"><span>»</span></a> ';
      }

      pagination_links.innerHTML = html;

    }

    this.add_pagination_event_handlers();
  };

};

window.outgoing_links = new window.outgoing_links_class();
window.outgoing_links.init();
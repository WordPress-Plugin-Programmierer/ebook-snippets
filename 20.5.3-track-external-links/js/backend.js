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
      self.init_link_form();
      self.init_delete_links();
    } );

    wp.api.loadPromise.done( function () {
      self.init_backbone();
    } );

    this.find_current_page_from_url();

    this.constants = window.tel_script_constants;
  };

  this.init_delete_links = function () {
    var self  = this;
    var links = document.querySelectorAll( '#the-list .delete a' );

    for ( var i = 0; i < links.length; i ++ ) {
      links[i].addEventListener( 'click', function ( e ) {
        e.preventDefault();

        var regex = new RegExp( 'id=([0-9]+)' );

        var id = parseInt( e.target.getAttribute( 'href' ).match( regex )[1] );

        self.delete_link( id );
      } );
    }
  };

  this.init_link_form = function () {
    var self = this;

    document.querySelector( '#add_new_form .button' ).addEventListener( 'click', function ( e ) {
      e.preventDefault();
      var form_data = new FormData( document.querySelector( '#add_new_form' ) );

      if ( '' === form_data.get( 'id' ) ) {
        self.add_link( form_data );
      }
      else {
        self.update_link( form_data );
      }
    } );
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
      'per_page': this.get_per_page()
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


  /**
   * Adds a link to the database.
   *
   * @since 0.4.0
   * @param form_data
   */
  this.add_link = function ( form_data ) {
    var self = this;

    /* We need the REST-API nonce, not the form-nonce. */
    form_data.delete( '_wpnonce' );

    wp.apiFetch( {
      'path':   '/tel/v1/outgoing-links',
      'method': 'POST',
      'body':   form_data
    } ).then( function ( data ) {
      self.add_link_to_table( data );
    } ).catch( function ( error ) {
      console.error( error );
      alert( self.constants.i18n.an_error_occurred.replace( '%s', error.message ) );
    } );
  };


  /**
   * Sends changes from a link to the database.
   *
   * @since 0.4.0
   * @param form_data
   */
  this.update_link = function ( form_data ) {
    var self = this;

    /* We need the REST-API nonce, not the form-nonce. */
    form_data.delete( '_wpnonce' );

    var id = form_data.get( 'id' );
    form_data.delete( 'id' );

    wp.apiFetch( {
         'path':   '/tel/v1/outgoing-links/' + id,
         'method': 'POST',
         'body':   form_data
       } ).
       then( function ( data ) {
         self.update_link_in_table( data );
       } ).catch( function ( error ) {
      console.error( error );
      alert( self.constants.i18n.an_error_occurred.replace( '%s', error.message ) );
    } );

  };


  /**
   * Adds a new link to the list table.
   *
   * @since 0.4.0
   * @param link
   */
  this.add_link_to_table = function ( link ) {
    var table = document.getElementById( 'the-list' );
    var row   = table.insertRow( 0 );

    /* id field */
    var cell_id       = row.insertCell( 0 );
    var cell_id_input = function ( link_id ) {
      var child = document.createElement( 'input' );
      child.setAttribute( 'type', 'checkbox' );
      child.setAttribute( 'name', 'bulk-delete[]' );
      child.setAttribute( 'value', link_id );
      return child;
    }( link.id );
    cell_id.appendChild( cell_id_input );

    /* title field */
    var cell_title      = row.insertCell( 1 );
    var cell_title_html = function ( link_url, link_title ) {
      var child = document.createElement( 'a' );
      child.setAttribute( 'href', link_url );
      child.setAttribute( 'target', '_blank' );
      child.innerText = link_title;
      return child;
    }( link.link, link.title );
    cell_title.appendChild( cell_title_html );
    var cell_title_actions = function ( i18n, link_id, delete_link ) {
      var div = document.createElement( 'div' );
      div.setAttribute( 'class', 'row-actions' );

      /* span1 */
      var span1 = document.createElement( 'span' );
      span1.setAttribute( 'class', 'edit' );

      /* link1 */
      var link1 = document.createElement( 'a' );
      link1.setAttribute( 'href', '#' );
      link1.setAttribute( 'data-id', link_id );
      link1.addEventListener( 'click', edit_link );
      link1.innerText = i18n.edit;

      span1.appendChild( link1 );
      span1.appendChild( document.createTextNode( ' | ' ) );
      div.appendChild( span1 );

      /* span 2 */
      var span2 = document.createElement( 'span' );
      span2.setAttribute( 'class', 'delete' );

      /* link 2 */
      var link2 = document.createElement( 'a' );
      link2.setAttribute( 'href', delete_link.replace( '##id##', link_id ) );
      link2.innerText = i18n.delete;

      span2.appendChild( link2 );
      div.appendChild( span2 );


      return div;
    }( this.constants.i18n, link.id, this.constants.delete_link );
    cell_title.appendChild( cell_title_actions );

    /* outgoing link field */
    var cell_outoing       = row.insertCell( 2 );
    var cell_outgoing_html = function ( link_url ) {
      var child = document.createElement( 'a' );
      child.setAttribute( 'href', link_url );
      child.setAttribute( 'target', '_blank' );
      child.innerText = link_url;
      return child;
    }( this.constants.site_url + 'out/' + link.slug );
    cell_outoing.appendChild( cell_outgoing_html );

    /* going-to field */
    var cell_goingto      = row.insertCell( 3 );
    var cell_goingto_html = function ( link_url ) {
      var child = document.createElement( 'a' );
      child.setAttribute( 'href', link_url );
      child.setAttribute( 'target', '_blank' );
      child.innerText = link_url;
      return child;
    }( link.link );
    cell_goingto.appendChild( cell_goingto_html );

    /* count field */
    var cell_count = row.insertCell( 4 );
    cell_count.appendChild( document.createTextNode( link.count ) );
  };


  /**
   * Updates a link in a table.
   *
   * @since 0.4.0
   * @param link
   */
  this.update_link_in_table = function ( link ) {
    var checkbox = document.querySelector(
        '#the-list input[type="checkbox"][value="' + link.id + '"]'
    );

    if ( checkbox.length <= 1 ) {
      return;
    }

    var row = checkbox.parentNode.parentNode;

    /* the title */
    var link_title = row.querySelector( 'td:nth-child(2) a' );
    link_title.setAttribute( 'href', link.link );
    link_title.innerText = link.title;

    /* outgoing link */
    var outgoing_link = row.querySelector( 'td:nth-child(3) a' );
    outgoing_link.setAttribute( 'href', this.constants.site_url + 'out/' + link.slug );
    outgoing_link.innerText = this.constants.site_url + 'out/' + link.slug;

    /* going to */
    var goingto_link = row.querySelector( 'td:nth-child(4) a' );
    goingto_link.setAttribute( 'href', link.link );
    goingto_link.innerText = link.link;

    /* count */
    var count       = row.querySelector( 'td:nth-child(5)' );
    count.innerText = link.count;

  };

  this.delete_link = function ( id ) {
    var self = this;

    jQuery.ajax( {
      'url':        self.constants.rest_url + 'tel/v1/outgoing-links/' + id,
      'dataType':   'json',
      'method':     'DELETE',
      'beforeSend': function ( xhr ) {
        xhr.setRequestHeader( 'X-WP-Nonce', self.constants.rest_nonce );
      }
    } ).done( function ( data ) {
      if ( data.hasOwnProperty( 'deleted' ) && data.deleted ) {
        self.delete_link_from_table( id );
      }
    } ).fail( function ( xhr, text_status, error ) {
      alert( self.i18n.an_error_occurred.replace( '%s', error ) );
    } );
  };

  this.delete_link_from_table = function ( id ) {
    var checkbox = document.querySelector( 'input[name="bulk-delete[]"][value="' + id + '"]' );
    var row      = checkbox.parentNode.parentNode;
    row.parentNode.removeChild( row );
  };


};

window.outgoing_links = new window.outgoing_links_class();
window.outgoing_links.init();
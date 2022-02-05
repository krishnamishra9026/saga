( function( d ) {
  'use strict';
  
  var vid = document.getElementById("audio-player");
	vid.volume = 0.5;

   var test = true,
       but = d.querySelector( '#audio-button' ),
       aud = d.querySelector( '#audio-player' );
       aud.classList.add( 'audio-remove' );
       d.querySelector( '#audio-button-container' ).classList.remove( 'hide' );

   but.addEventListener('click',
      function() {
         if ( test === true ) {
              but.classList.add( 'audio-pause' );
              test = false;
              aud.play();
         }
         else {
              changeSVG();
              aud.pause();
         }
      }, false );

   aud.addEventListener( 'ended',
      function() {
         changeSVG();
         aud.load();
       }, false );

   function changeSVG() {
      but.classList.remove( 'audio-pause' );
      test = true;
    }
 }( document ));
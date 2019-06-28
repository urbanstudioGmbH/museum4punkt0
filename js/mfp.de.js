// Add it after jquery.magnific-popup.js and before first initialization code
jQuery.extend(true, jQuery.magnificPopup.defaults, {
  tClose: 'Schließen (Esc)', // Alt text on close button
  tLoading: 'Laden...', // Text that is displayed during loading. Can contain %curr% and %total% keys
  gallery: {
    tPrev: 'Zurück', // Alt text on left arrow
    tNext: 'Vor', // Alt text on right arrow
    tCounter: '%curr% von %total%' // Markup for "1 of 7" counter
  },
  image: {
    tError: 'Das <a href="%url%">Bild</a> konnte nicht geladen werden.' // Error message when image could not be loaded
  },
  ajax: {
    tError: 'Der <a href="%url%">Inhalt</a> konnte nicht geladen werden.' // Error message when ajax request failed
  }
});
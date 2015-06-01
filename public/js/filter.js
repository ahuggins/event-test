$(document).ready(function() {
    var $container = $('#events').imagesLoaded( function() {
      $container.isotope({
        itemSelector: '.event',
        layoutMode: 'masonry'
      });
    });

      $('form[data-remote]').on('submit', function(e) {
          e.preventDefault();
        var form = $(this);
        var method = form.find('input[name="_method"]').val() || 'POST';
        var url = form.prop('action');
        var value = $(this).find('input[type="submit"]').val();
        $.ajax({
            type: method,
            url: url,
            data: form.serialize(),
            success: function() {
                if (value == 'Attend') {
                    form.find('input[name=attending]').val('true');
                    form.find('input[type=submit]').val('Attending');
                } else {
                    form.find('input[name=attending]').val('false');
                    form.find('input[type=submit]').val('Attend');
                };

            }
        });
    });
  // store filter for each group
  var filters = {};

  $('#filters').on( 'click', '.btn', function() {
    var $this = $(this);
    // get group key
    var $buttonGroup = $this.parents('.btn-group');
    var filterGroup = $buttonGroup.attr('data-filter-group');
    // set filter for group
    filters[ filterGroup ] = $this.attr('data-filter');
    // combine filters
    var filterValue = '';
    for ( var prop in filters ) {
      filterValue += filters[ prop ];
    }
    // set filter for Isotope
    $container.isotope({ filter: filterValue });
  });

  // change is-checked class on buttons
  $('.btn-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function() {
      $buttonGroup.find('.is-checked').removeClass('is-checked');
      $( this ).addClass('is-checked');
    });
  });
});

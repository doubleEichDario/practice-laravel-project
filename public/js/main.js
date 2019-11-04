var url = 'http://laragram.com';

window.addEventListener("load", function() {

  function like() {

    $('.pub-interactions-dislike').unbind('click').click(function() {

      console.log('like');
      $(this).addClass('pub-interactions-like').removeClass('pub-interactions-dislike');
      $(this).attr('src', url + '/img/redheart.png');

      $.ajax({
        url: url + '/like/' + $(this).data('id'),
        type: 'GET',
        success: function(response) {

          if(response) {

            console.log(response.message);

          }

        }

      });

      dislike();

    });

  }

  like();

  function dislike() {

    $('.pub-interactions-like').unbind('click').click(function() {

      console.log('dislike');
      $(this).addClass('pub-interactions-dislike').removeClass('pub-interactions-like');
      $(this).attr('src', url + '/img/grayheart.png');

      $.ajax({
        url: url + '/dislike/' + $(this).data('id'),
        type: 'GET',
        success: function(response) {

          if(response) {

            console.log(response.message);

          }

        }

      });

      like();

    });

  }

  dislike();

  // Searcher
  $('#people-searcher').submit(function() {
    $(this).attr('action', url + '/people/' + $('#people-searcher #search').val());
    $(this).submit();
  })

});

var postBodyElement = null;
var postBody = 0;
$('.post').find('.interaction').find('.edit').on('click', function (event) {
    event.preventDefault();

    postBodyElement = event.target.parentNode.parentNode.childNodes[1];
    var postBody = postBodyElement.textContent;
    postId = event.target.parentNode.parentNode.dataset['postid'];
    $('#post-body').val(postBody);
    $('#edit-modal').modal();
});

$('#modal-save').on('click', function () {
    $.ajax({
            method: 'POST',
            url: urlEdit,
            data: {body: $('#post-body').val(), postId: postId, _token: token}
        })
        .done(function (msg) {
            $(postBodyElement).text(msg['new_body']);
            $('#edit-modal').modal('hide');
        });
});
//likes and dislikes event handling//
$('.like').on('click',function(event){
    event.preventDefault();

    postId = event.target.parentNode.parentNode.dataset['postid'];

    //previous element sibling logic to distinguish like and dislike i.e like has no previous element sibling and dislike has like
    var isLike = event.target.previousElementSibling === null;
    $.ajax({
        method: 'POST',
        url: urlLike,
        data: {isLike: isLike, postId: postId, _token: token }
    })
    .done(function(){
        event.target.innerText = isLike ? event.target.innerText == 'Like' ? 'Liked' : 'Like' : event.target.innerText == 'Disliked' ? 'Dislike' : 'Disliked' ;
        if(isLike){
            event.target.nextElementSibling.innerText = 'Dislike';
        }else{
            event.target.previousElementSibling.innerText = 'Like';
        }
    });
    
});

document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('btnviewshop');
    if (btn && typeof aumarketUser !== 'undefined' && aumarketUser.username) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = '/user/' + aumarketUser.username + '/';
        });
    }
}); 
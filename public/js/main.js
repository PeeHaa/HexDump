(function() {
    var convertForm = document.getElementById('convertform');
    if (convertForm) {
        var submitButton = document.querySelector('header .button');
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();

            convertForm.submit();
        });
    }
}());
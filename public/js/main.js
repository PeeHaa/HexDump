(function() {
    var convertForm = document.getElementById('convertform');
    if (convertForm) {
        var submitButton = document.querySelector('header .button');
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();

            convertForm.submit();
        });
    }

    var lineHighlighter = function(hash) {
        var spans = document.querySelectorAll('pre span');
        for (var i = 0, l = spans.length; i < l; i++) {
            spans[i].setAttribute('class', '');
        }

        var line = document.getElementById(location.hash.slice(1, 8));
        if (line) {
            line.setAttribute('class', 'active');
        }
    };

    var searchbox = document.querySelector('form input[type="text"][name="search"]');
    if (searchbox) {
        searchbox.addEventListener('input', function(e) {
            if (searchbox.value == '') {
                return;
            }

            searchbox.value = searchbox.value.replace(/\s+/g, '').match(/.{1,2}/g).join(' ');
        });
    }

    window.addEventListener('hashchange', lineHighlighter, false);
}());
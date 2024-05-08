<?php
$currentURL = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<div id="social-sensei-modal" class="modal modal--lg">
    <div class="modal__dialog">
        <div class="modal__content">
            <span class="modal__close" data-modal-close></span>
            <header class="modal__header">
                <h2 class="modal__title">Share this page on <span class="modal__social"></span></h2>
                <p class="modal__instructions">Click the button below to share to <span class="modal__social"></span></p>
            </header>
            <section class="modal__body">
                <p>Loading...</p>
                <button id="modal__body--copy-button">
                    <svg class="copy" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M384 336H192c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16l140.1 0L400 115.9V320c0 8.8-7.2 16-16 16zM192 384H384c35.3 0 64-28.7 64-64V115.9c0-12.7-5.1-24.9-14.1-33.9L366.1 14.1c-9-9-21.2-14.1-33.9-14.1H192c-35.3 0-64 28.7-64 64V320c0 35.3 28.7 64 64 64zM64 128c-35.3 0-64 28.7-64 64V448c0 35.3 28.7 64 64 64H256c35.3 0 64-28.7 64-64V416H272v32c0 8.8-7.2 16-16 16H64c-8.8 0-16-7.2-16-16V192c0-8.8 7.2-16 16-16H96V128H64z"/></svg>
                    <svg class="check" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                </button>
            </section>
            <section class="modal__body--help">
                <small></small>
            </section>
            <footer class="modal__footer u--text-align-right">

                <a class="btn btn--green" id="social-sensei-share-li" href="#" target="_blank" rel="noopener"></a>
                <a class="btn btn--green" id="social-sensei-regenerate">Re-generate</a>
                <a class="btn btn--red" data-modal-close>Close</a>
            </footer>
        </div>
    </div>
</div>

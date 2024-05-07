<?php
$currentURL = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
?>
<div id="social-sensei-modal" class="modal modal--lg">
    <div class="modal__dialog">
        <div class="modal__content">
            <span class="modal__close" data-modal-close></span>
            <header class="modal__header">
                <h2 class="modal__title">Share this page on <span class="modal__social"></span></h2>
                <h6 class="modal__instructions">Click the button below to share to <span class="modal__social"></span></h6>
            </header>
            <section class="modal__body">
                <p>Loading...</p>
                <button id="modal__body--copy-button">Copy Text</button>
            </section>
            <footer class="modal__footer u--text-align-right">
              <!-- TODO: Make Regenerate button work -->
                <!-- <a href="#modal-extra-small" class="btn" id="social-sensei-regenerate">Re-generate</a> -->
                <a class="btn" id="social-sensei-share-li" href="#" target="_blank" rel="noopener"></a>
                <a href="#modal-extra-small" class="btn" data-modal-close>Close</a>
            </footer>
        </div>
    </div>
</div>

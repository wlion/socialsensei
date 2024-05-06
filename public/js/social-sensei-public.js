(function ($) {
  "use strict";

  $(window).on("load", function () {
    let currentPageUrl = window.location.href;
    currentPageUrl = currentPageUrl.split('#')[0];
    const $modal = $("#social-sensei-modal");
    const socialMappings = {
      twitter: {
        url: "https://twitter.com/intent/tweet?url=" + currentPageUrl + "&text=",
      },
      linkedin: {
        url: "https://www.linkedin.com/shareArticle?mini=true&url=" + currentPageUrl + "&text=",
      },
    };

    if ($modal.length > 0) {
      const $modalClose = $modal.find("[data-modal-close]");

      $modalClose.each(function () {
        $(this).on("click", function () {
          $modal.removeClass("modal--visible");
        });
      });
    }

    // On Click
    $("#wp-admin-bar-social-sensei_social_summary-default").on(
      "click",
      "a",
      function (event) {
        event.preventDefault();
        const hrefValue = $(this).attr("href").substring(1);

        // use hrefValue to set share button text and href
        $('#social-sensei-share-li').attr('href', socialMappings[hrefValue].url);
        $('#social-sensei-share-li').text('Share to ' + hrefValue.toUpperCase());

        // Social Sensei
        $modal.addClass("modal--visible");
        const $social = $(this).text();
        const $socialTexts = $modal.find(".modal__social");

        $socialTexts.each(function () {
          $(this).text($social);
        });

        // Response Data
        
        const main = document.querySelector("main").innerHTML;

        // URL of the endpoint you want to send the POST request to
        const endpointUrl =
          window.socialSenseiAjax.ajax_url + "?action=wl_generate_summary";

        // Data to be sent in the POST request (replace with your data)
        const postData = {
          data: main,
        };

        // Options for the fetch request
        const fetchOptions = {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(postData),
        };

        // Perform the POST request using fetch
        fetch(endpointUrl, fetchOptions)
          .then((response) => {
            if (!response.ok) {
              throw new Error("Network response was not ok");
            }
            return response.json(); // Parse the response as JSON (or text, depending on the API)
          })
          .then((data) => {
            const responseData = data.data.choices[0].message.content;
            $modal.find(".modal__body p").text(responseData);
            // add the response as the text to the share button
            $("#social-sensei-share-li").attr("href", function (i, prevHref) {
              return prevHref + responseData;
            });
          })
          .catch((error) => {
            // Handle errors during the fetch
            console.error("Fetch error:", error);
          });
      }
    );
  });

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
})(jQuery);

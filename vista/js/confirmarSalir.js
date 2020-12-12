/*!
 * jQuery confirmExit plugin
 * https://github.com/dunglas/jquery.confirmExit
 *
 * Copyright 2012 Kévin Dunglas <dunglas@gmail.com>
 * Released under the MIT license
 * http://www.opensource.org/licenses/mit-license.php
 */
(function ($) {
    $.fn.confirmarSalir = function (message) {
        var confirmarSalir = false;

        $('input, textarea, select', this).on('change keyup', function () {
            // Do not set the event handler if not needed
            if (!confirmarSalir) {
                confirmarSalir = true;

                window.onbeforeunload = function (event) {
                    var e = event || window.event;

                    // For old IE and Firefox
                    if (e) {
                        e.returnValue = message;
                    }

                    return message;
                }
            }
        });

        this.submit(function () {
            window.onbeforeunload = null;
            confirmarSalir = false;
        });

        return this;
    }
})(jQuery);
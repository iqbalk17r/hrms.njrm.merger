Selectize.define('hide-arrow', function (options) {
    options = $.extend({
    }, options);

    var self = this;
    this.setup = (function () {
        var original = self.setup;
        return function () {
            // override the item rendering method to add the button to each
            original.apply(this, arguments);

            var $wrappedInput = this.$wrapper.find(".selectize-input");

            var handleArrow = function ($inpt) {
                if ($inpt.val()) {
                    $wrappedInput.addClass("no-arrow");
                } else {
                    $wrappedInput.removeClass("no-arrow");
                }
            };

            var $input = this.$input;
            handleArrow($input);
            $input.change(function () {
                handleArrow($input);
            });
        };
    })();
});

Selectize.define('selectable-placeholder', function (options) {
    var self = this;

    options = $.extend({
        placeholder: self.settings.placeholder,
        html: function (data) {
            return (
            '<div class="selectize-dropdown-content placeholder-container">' +
            '<div data-selectable class="option">' + data.placeholder + '</div>' +
            '</div>');
        }
    }, options);

    // override the setup method to add an extra "click" handler
    self.setup = (function () {
        var original = self.setup;
        return function () {
            original.apply(this, arguments);
            self.$placeholder_container = $(options.html(options));
            self.$dropdown.prepend(self.$placeholder_container);
            self.$dropdown.on('click', '.placeholder-container', function () {
                self.setValue('');
                self.close();
                self.blur();
            });
        };
    })();

});

Selectize.define('infinite-scroll', function(options) {
    var self = this
        , page = 1;

    self.infinitescroll = {
        onScroll: function() {
            var scrollBottom = self.$dropdown_content[0].scrollHeight - (self.$dropdown_content.scrollTop() + self.$dropdown_content.height())
            if(scrollBottom < 300){
                var query = JSON.stringify({
                    search: self.lastValue,
                    page: page
                })

                self.$dropdown_content.off('scroll')
                self.onSearchChange(query)
            }
        }
    };

    self.onFocus = (function() {
        var original = self.onFocus;

        return function() {
            var query = JSON.stringify({
                search: self.lastValue,
                page: page
            })

            original.apply(self, arguments);
            self.onSearchChange(query)
        };
    })();

    self.onKeyUp = function(e) {
        var self = this;

        if (self.isLocked) return e && e.preventDefault();
        var value = self.$control_input.val() || '';

        if (self.lastValue !== value) {
            var query = JSON.stringify({
                search: value,
                page: page = 1
            });

            self.lastValue = value;
            self.onSearchChange(query);
            self.refreshOptions();
            self.clearOptions();
            self.trigger('type', value);
        }
    };

    self.on('load',function(){
        page++
        self.$dropdown_content.on('scroll', self.infinitescroll.onScroll);
    });

});
(function (wp) {
    'use strict';
    var closeActive;
    ['icon_color', 'icon_bg_color', 'icon_hover_color', 'icon_hover_bg_color'].forEach(function (field) {
        wp.customize.control('xstr_option[' + field + ']', function (control) {
            var container = control.container[0].querySelector('.xscroll-color-control');
            if (!container) return;
            var mount = container.querySelector('.xscroll-color-picker');
            var button = container.querySelector('.xscroll-color-toggle');
            var swatch = container.querySelector('.xscroll-color-swatch');
            var readout = container.querySelector('.xscroll-color-value');
            var root;
            var open = false;
            var el = wp.element.createElement;
            // Normalize the display only; opening the picker never rewrites a setting.
            function displayColor(value) {
                if (/^#[0-9a-f]{3,8}$/i.test(value)) return value;
                var context = document.createElement('canvas').getContext('2d');
                context.fillStyle = value || mount.dataset.default;
                context.fillRect(0, 0, 1, 1);
                return '#' + Array.from(context.getImageData(0, 0, 1, 1).data).map(function (channel) {
                    return channel.toString(16).padStart(2, '0');
                }).join('');
            }
            function close() {
                open = false;
                if (closeActive === close) closeActive = null;
                render(control.setting.get());
            }
            function render(value) {
                swatch.style.backgroundColor = value || mount.dataset.default;
                button.style.backgroundColor = value || mount.dataset.default;
                var hex = displayColor(value).slice(1);
                if (hex.length <= 4) hex = hex.split('').map(function (digit) { return digit + digit; }).join('');
                var alpha = hex.length === 8 ? parseInt(hex.slice(6, 8), 16) / 255 : 1;
                var brightness = [0.299, 0.587, 0.114].reduce(function (sum, weight, index) {
                    return sum + weight * (parseInt(hex.slice(index * 2, index * 2 + 2), 16) * alpha + 255 * (1 - alpha));
                }, 0);
                readout.style.color = brightness > 175 ? '#1e1e1e' : '#fff';
                button.setAttribute('aria-expanded', String(open));
                if (!open && !root && wp.element.createRoot) return;
                var content = open ? el(wp.components.Popover, {
                    anchor: button,
                    placement: 'right-start',
                    animate: false,
                    position: 'middle right',
                    offset: 12,
                    className: 'xscroll-color-popover',
                    onClose: close,
                    onFocusOutside: function (event) { if (!button.contains(event.target)) close(); },
                    expandOnMobile: true,
                    headerTitle: control.params.label
                }, el('div', { className: 'xscroll-color-popover-inner' },
                    el(wp.components.ColorPicker, {
                        color: displayColor(value),
                        enableAlpha: true,
                        onChange: function (color) { control.setting.set(color); }
                    }),
                    el(wp.components.Button, {
                        variant: 'tertiary',
                        onClick: function () { control.setting.set(mount.dataset.default); }
                    }, mount.dataset.reset)
                )) : null;
                if (wp.element.createRoot) {
                    if (!root) root = wp.element.createRoot(mount);
                    root.render(content);
                } else {
                    wp.element.render(content, mount);
                }
            }
            button.addEventListener('click', function () {
                if (!open && closeActive) closeActive();
                open = !open;
                closeActive = open ? close : null;
                render(control.setting.get());
            });
            control.setting.bind(render);
            render(control.setting.get());
        });
    });
})(window.wp);

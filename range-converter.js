module.exports = function () {
    var output = [];
    var range = [];
    var separator = ',';
    var rangeSeparator = '..';

    function sort(a, b) {
        return a - b;
    }

    // Borrowed and adapted from underscore.js
    function arrayRange(start, stop) {
        step = 1;

        var length = Math.max(Math.ceil((stop - start) / step), 0);
        var range = Array(length);

        for (var idx = 0; idx < length; idx++, start += step) {
            range[idx] = start;
        }

        return range;
    }

    function nextInRange(number) {
        if (!range.length || number - range[range.length - 1] === 1) {
            range.push(number);

            return;
        }

        clearRange();

        range.push(number);
    }

    function clearRange() {
        if (range.length) {
            output.push(addRangeToOutput());
            range = [];
        }
    }

    function addRangeToOutput() {
        if (range.length === 1) {
            return range.pop();
        }

        if (range.length === 2) {
            return range.join(separator);
        }

        var first = range.shift();
        var last = range.pop();

        return first + rangeSeparator + last;
    }


    return {
        reduce: function (arr) {
            arr = arr.sort(sort);
            var length = arr.length;

            for (var i = 0; i < length; i++) {
                nextInRange(arr[i]);
            }

            clearRange();

            return output.join(separator);
        },

        expand: function (str) {
            var ranges = str.split(separator);
            var output = [];
            var length = ranges.length;

            for (var i = 0; i < length; i++) {
                var rangeString = ranges[i];

                if (!isNaN(rangeString)) {
                    output.push(Number(rangeString));
                    continue;
                }

                var parts = rangeString.split(rangeSeparator);
                var first = Number(parts.shift());
                var last = Number(parts.pop()) + 1;

                output = output.concat(arrayRange(first, last));
            }

            return output;
        },

        setSeparator: function (character) {
            separator = character;

            return this;
        },

        setRangeSeparator: function (character) {
            rangeSeparator = character;

            return this;
        }
    };
};


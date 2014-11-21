// Node.js tests
var buster = require("buster");
var ranger = require("../../range-converter");
var assert = buster.referee.assert;

buster.testCase("RangeConverter", {
    setUp: function () {
        this.R = new ranger();
    },

    "test it convers array to range": function () {
        assert.equals('1..5', this.R.reduce([1, 2, 3, 4, 5]));
    },

    "test it converts an array to a range mixed": function () {
        assert.equals('1..3,5', this.R.reduce([1, 2, 3, 5]));
    },

    "test it works with random order": function () {
        assert.equals('1..3,5', this.R.reduce([1, 3, 2, 5]));
    },

    "test multiple ranges": function () {
        assert.equals('1..3,5,8..11', this.R.reduce([1, 2, 3, 5, 8, 9, 10, 11]));
    },

    "test it ignores short ranges": function () {
        assert.equals('1,2,5', this.R.reduce([1, 2, 5]));
    },

    "test it ignores multiple short ranges": function () {
        assert.equals('1,2,5,6,9..11', this.R.reduce([1, 2, 5, 6, 9, 10, 11]));
    },

    "test custom separators": function () {
        var r = new ranger();
        var result = r.setSeparator('|').setRangeSeparator(',').reduce([1, 2, 5, 6, 9, 10, 11]);
        assert.equals('1|2|5|6|9,11', result);
    },

    "test range in the middle": function () {
        assert.equals('1,5..7,10', this.R.reduce([1, 5, 6, 7, 10]));
    },

    "test expansion": function() {
        assert.equals([1,5,6,7,10], this.R.expand('1,5..7,10'));
    }

});
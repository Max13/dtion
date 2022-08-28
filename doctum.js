

(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '<ul><li data-name="namespace:" class="opened"><div style="padding-left:0px" class="hd"><span class="icon icon-play"></span><a href="[Global_Namespace].html">[Global Namespace]</a></div><div class="bd"><ul><li data-name="class:Stringable" class="opened"><div style="padding-left:26px" class="hd leaf"><a href="Stringable.html">Stringable</a></div></li></ul></div></li><li data-name="namespace:Dtion" class="opened"><div style="padding-left:0px" class="hd"><span class="icon icon-play"></span><a href="Dtion.html">Dtion</a></div><div class="bd"><ul><li data-name="namespace:Dtion_Exceptions" class="opened"><div style="padding-left:18px" class="hd"><span class="icon icon-play"></span><a href="Dtion/Exceptions.html">Exceptions</a></div><div class="bd"><ul><li data-name="class:Dtion_Exceptions_CriterionDoesntMatchException" ><div style="padding-left:44px" class="hd leaf"><a href="Dtion/Exceptions/CriterionDoesntMatchException.html">CriterionDoesntMatchException</a></div></li></ul></div></li><li data-name="class:Dtion_Dtion" class="opened"><div style="padding-left:26px" class="hd leaf"><a href="Dtion/Dtion.html">Dtion</a></div></li><li data-name="class:Dtion_DtionList" class="opened"><div style="padding-left:26px" class="hd leaf"><a href="Dtion/DtionList.html">DtionList</a></div></li></ul></div></li></ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                        {"type":"Namespace","link":"[Global_Namespace].html","name":"","doc":"Namespace "},{"type":"Namespace","link":"Dtion.html","name":"Dtion","doc":"Namespace Dtion"},{"type":"Namespace","link":"Dtion/Exceptions.html","name":"Dtion\\Exceptions","doc":"Namespace Dtion\\Exceptions"},                    {"type":"Interface","link":"Stringable.html","name":"Stringable","doc":"<p>Interface to store stringable elements in Dtion</p>"},
                                {"type":"Method","fromName":"Stringable","fromLink":"Stringable.html","link":"Stringable.html#method___toString","name":"Stringable::__toString","doc":"<p>Implicitely implements PHP Stringable interface\nfor PHP&lt;=8.0 .</p>"},
            
                                                        {"type":"Class","fromName":"Dtion","fromLink":"Dtion.html","link":"Dtion/Dtion.html","name":"Dtion\\Dtion","doc":"<p>This class stores a condition (lower and upper boundaries) and a result.</p>"},
                                {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method___construct","name":"Dtion\\Dtion::__construct","doc":"<p>Instanciate a Dtion with a lower boundary, upper boundary and\nthe result when the criterion is between these boundaries.</p>"},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method_make","name":"Dtion\\Dtion::make","doc":"<p>Static mode to instanciate a Dtion</p>"},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method_result","name":"Dtion\\Dtion::result","doc":"<p>Return the stored result</p>"},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method_match","name":"Dtion\\Dtion::match","doc":"<p>Match a criterion with lower and upper boundaries.</p>"},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method_normalize","name":"Dtion\\Dtion::normalize","doc":"<p>Normalize data if necessary, before sending to constructor</p>"},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method_fromArray","name":"Dtion\\Dtion::fromArray","doc":"<p>Instanciate from array, given by self::toArray() method</p>"},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method_toArray","name":"Dtion\\Dtion::toArray","doc":""},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method_fromJson","name":"Dtion\\Dtion::fromJson","doc":"<p>Instanciate from JSON, given by self::toJson() method</p>"},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method_toJson","name":"Dtion\\Dtion::toJson","doc":""},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method___serialize","name":"Dtion\\Dtion::__serialize","doc":""},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method___unserialize","name":"Dtion\\Dtion::__unserialize","doc":""},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method_serialize","name":"Dtion\\Dtion::serialize","doc":""},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method_unserialize","name":"Dtion\\Dtion::unserialize","doc":""},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method___toString","name":"Dtion\\Dtion::__toString","doc":""},
            
                                                {"type":"Class","fromName":"Dtion","fromLink":"Dtion.html","link":"Dtion/DtionList.html","name":"Dtion\\DtionList","doc":"<p>This class stores a list of Dtion, allowing the user to find() the\ncorresponding Dtion (therefor the result) among multiple conditions.</p>"},
                                {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method___construct","name":"Dtion\\DtionList::__construct","doc":"<p>Construct an empty Dtion</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_make","name":"Dtion\\DtionList::make","doc":"<p>Static mode to instanciate a Dtion</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_push","name":"Dtion\\DtionList::push","doc":"<p>Push a Dtion to the list.</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_find","name":"Dtion\\DtionList::find","doc":"<p>Find the first dtion to match $critera, and returns it or null otherwise.</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_resultFor","name":"Dtion\\DtionList::resultFor","doc":"<p>Find the first dtion to match $critera, and returns it's result.</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_fromArray","name":"Dtion\\DtionList::fromArray","doc":"<p>Instanciate from array of arrays, given by self::toArray() method</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_toArray","name":"Dtion\\DtionList::toArray","doc":""},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_fromJson","name":"Dtion\\DtionList::fromJson","doc":"<p>Instanciate from JSON, given by self::toJson() method</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_toJson","name":"Dtion\\DtionList::toJson","doc":""},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_count","name":"Dtion\\DtionList::count","doc":""},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method___serialize","name":"Dtion\\DtionList::__serialize","doc":""},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method___unserialize","name":"Dtion\\DtionList::__unserialize","doc":""},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_serialize","name":"Dtion\\DtionList::serialize","doc":""},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_unserialize","name":"Dtion\\DtionList::unserialize","doc":""},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method___toString","name":"Dtion\\DtionList::__toString","doc":""},
            
                                                {"type":"Class","fromName":"Dtion\\Exceptions","fromLink":"Dtion/Exceptions.html","link":"Dtion/Exceptions/CriterionDoesntMatchException.html","name":"Dtion\\Exceptions\\CriterionDoesntMatchException","doc":"<p>Exception thrown when a criteria doesn't match any Dtion in DtionList.</p>"},
                
                    {"type":"Class","link":"Stringable.html","name":"Stringable","doc":"<p>Interface to store stringable elements in Dtion</p>"},
                                {"type":"Method","fromName":"Stringable","fromLink":"Stringable.html","link":"Stringable.html#method___toString","name":"Stringable::__toString","doc":"<p>Implicitely implements PHP Stringable interface\nfor PHP&lt;=8.0 .</p>"},
            
                                // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Doctum = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Doctum.injectApiTree($('#api-tree'));
    });

    return root.Doctum;
})(window);

$(function() {

    
    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').on('click', function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Doctum.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});



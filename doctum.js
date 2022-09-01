

(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '<ul><li data-name="namespace:Dtion" class="opened"><div style="padding-left:0px" class="hd"><span class="icon icon-play"></span><a href="Dtion.html">Dtion</a></div><div class="bd"><ul><li data-name="namespace:Dtion_Contracts" class="opened"><div style="padding-left:18px" class="hd"><span class="icon icon-play"></span><a href="Dtion/Contracts.html">Contracts</a></div><div class="bd"><ul><li data-name="class:Dtion_Contracts_Dtionable" ><div style="padding-left:44px" class="hd leaf"><a href="Dtion/Contracts/Dtionable.html">Dtionable</a></div></li></ul></div></li><li data-name="namespace:Dtion_Exceptions" class="opened"><div style="padding-left:18px" class="hd"><span class="icon icon-play"></span><a href="Dtion/Exceptions.html">Exceptions</a></div><div class="bd"><ul><li data-name="class:Dtion_Exceptions_CriterionDoesntMatchException" ><div style="padding-left:44px" class="hd leaf"><a href="Dtion/Exceptions/CriterionDoesntMatchException.html">CriterionDoesntMatchException</a></div></li></ul></div></li><li data-name="class:Dtion_Dtion" class="opened"><div style="padding-left:26px" class="hd leaf"><a href="Dtion/Dtion.html">Dtion</a></div></li><li data-name="class:Dtion_DtionList" class="opened"><div style="padding-left:26px" class="hd leaf"><a href="Dtion/DtionList.html">DtionList</a></div></li></ul></div></li></ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                        {"type":"Namespace","link":"Dtion.html","name":"Dtion","doc":"Namespace Dtion"},{"type":"Namespace","link":"Dtion/Contracts.html","name":"Dtion\\Contracts","doc":"Namespace Dtion\\Contracts"},{"type":"Namespace","link":"Dtion/Exceptions.html","name":"Dtion\\Exceptions","doc":"Namespace Dtion\\Exceptions"},                                                        {"type":"Class","fromName":"Dtion\\Contracts","fromLink":"Dtion/Contracts.html","link":"Dtion/Contracts/Dtionable.html","name":"Dtion\\Contracts\\Dtionable","doc":"<p>This class stores the simplest form of a a condition\n(lower and upper boundaries) and a result.</p>"},
                                {"type":"Method","fromName":"Dtion\\Contracts\\Dtionable","fromLink":"Dtion/Contracts/Dtionable.html","link":"Dtion/Contracts/Dtionable.html#method___construct","name":"Dtion\\Contracts\\Dtionable::__construct","doc":"<p>Instanciate a Dtionable with a lower boundary, upper boundary and\nthe result when the criterion is between these boundaries.</p>"},
        {"type":"Method","fromName":"Dtion\\Contracts\\Dtionable","fromLink":"Dtion/Contracts/Dtionable.html","link":"Dtion/Contracts/Dtionable.html#method_match","name":"Dtion\\Contracts\\Dtionable::match","doc":"<p>Match a criterion with lower and upper boundaries.</p>"},
        {"type":"Method","fromName":"Dtion\\Contracts\\Dtionable","fromLink":"Dtion/Contracts/Dtionable.html","link":"Dtion/Contracts/Dtionable.html#method_result","name":"Dtion\\Contracts\\Dtionable::result","doc":"<p>Return the stored result</p>"},
        {"type":"Method","fromName":"Dtion\\Contracts\\Dtionable","fromLink":"Dtion/Contracts/Dtionable.html","link":"Dtion/Contracts/Dtionable.html#method_fromArray","name":"Dtion\\Contracts\\Dtionable::fromArray","doc":"<p>Instanciate a Dtionable from an associative array</p>"},
        {"type":"Method","fromName":"Dtion\\Contracts\\Dtionable","fromLink":"Dtion/Contracts/Dtionable.html","link":"Dtion/Contracts/Dtionable.html#method_toArray","name":"Dtion\\Contracts\\Dtionable::toArray","doc":"<p>Get the instance as an array.</p>"},
        {"type":"Method","fromName":"Dtion\\Contracts\\Dtionable","fromLink":"Dtion/Contracts/Dtionable.html","link":"Dtion/Contracts/Dtionable.html#method___serialize","name":"Dtion\\Contracts\\Dtionable::__serialize","doc":"<p>This method defines a serialization-friendly arbitrary representation\nof the object in form of an array.</p>"},
        {"type":"Method","fromName":"Dtion\\Contracts\\Dtionable","fromLink":"Dtion/Contracts/Dtionable.html","link":"Dtion/Contracts/Dtionable.html#method___unserialize","name":"Dtion\\Contracts\\Dtionable::__unserialize","doc":"<p>This method is passed the restored array that was returned\nfrom __serialize(). It may then restore the properties of the\nobject from that array as appropriate.</p>"},
            
                                                {"type":"Class","fromName":"Dtion","fromLink":"Dtion.html","link":"Dtion/Dtion.html","name":"Dtion\\Dtion","doc":"<p>This class stores a condition (lower and upper boundaries) and a result.</p>"},
                                {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method_make","name":"Dtion\\Dtion::make","doc":"<p>Static mode to instanciate a Dtion</p>"},
        {"type":"Method","fromName":"Dtion\\Dtion","fromLink":"Dtion/Dtion.html","link":"Dtion/Dtion.html#method_match","name":"Dtion\\Dtion::match","doc":"<p>Match a criterion with lower and upper boundaries.</p>"},
            
                                                {"type":"Class","fromName":"Dtion","fromLink":"Dtion.html","link":"Dtion/DtionList.html","name":"Dtion\\DtionList","doc":"<p>This class stores a list of Dtion, allowing the user to find() the\ncorresponding Dtion (therefor the result) among multiple conditions.</p>"},
                                {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method___construct","name":"Dtion\\DtionList::__construct","doc":"<p>Construct an empty Dtion</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_make","name":"Dtion\\DtionList::make","doc":"<p>Static mode to instanciate a Dtion</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_push","name":"Dtion\\DtionList::push","doc":"<p>Push a Dtion to the list.</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_find","name":"Dtion\\DtionList::find","doc":"<p>Find the first dtion to match $critera, and returns it or null otherwise.</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_resultFor","name":"Dtion\\DtionList::resultFor","doc":"<p>Find the first dtion to match $critera, and returns it's result.</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_fromArray","name":"Dtion\\DtionList::fromArray","doc":"<p>Instanciate from array of arrays, given by self::toArray() method</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_toArray","name":"Dtion\\DtionList::toArray","doc":""},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method_count","name":"Dtion\\DtionList::count","doc":""},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method___serialize","name":"Dtion\\DtionList::__serialize","doc":"<p>This method defines a serialization-friendly arbitrary representation\nof the object in form of an array.</p>"},
        {"type":"Method","fromName":"Dtion\\DtionList","fromLink":"Dtion/DtionList.html","link":"Dtion/DtionList.html#method___unserialize","name":"Dtion\\DtionList::__unserialize","doc":"<p>This method is passed the restored array that was returned\nfrom __serialize(). It may then restore the properties of the\nobject from that array as appropriate.</p>"},
            
                                                {"type":"Class","fromName":"Dtion\\Exceptions","fromLink":"Dtion/Exceptions.html","link":"Dtion/Exceptions/CriterionDoesntMatchException.html","name":"Dtion\\Exceptions\\CriterionDoesntMatchException","doc":"<p>Exception thrown when a criteria doesn't match any Dtion in DtionList.</p>"},
                
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



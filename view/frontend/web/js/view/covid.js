define([
        'jquery',
        'uiComponent',
        'ko',
        'Ghratzoo_Covid/js/service/covid',
        'chartJs'
    ],
    function($, Component, ko, covidService) {

        'use strict';

        ko.observableGroup = function(observables) {
            var observableManager = {};
            var throttle = 0;
            var throttleTimeout;

            observableManager.throttle = function(duration) {
                throttle = duration;
                return observableManager;
            };

            observableManager.subscribe = function(handler) {
                function throttledHandler(val) {
                    if(throttle > 0) {
                        if(!throttleTimeout) {
                            throttleTimeout = setTimeout(function() {
                                throttleTimeout = undefined;
                                handler(val);
                            }, throttle);
                        }
                    }
                    else
                    { handler(val); }
                }

                for(var i = 0; i < observables.length; i++)
                { observables[i].subscribe(throttledHandler); }

                return observableManager;
            };

            return observableManager;
        };

        var getType = function(obj) {
            if ((obj) && (typeof (obj) === "object") && (obj.constructor == (new Date).constructor)) return "date";
            return typeof obj;
        };

        var getSubscribables = function(model) {
            var subscribables = [];
            scanForObservablesIn(model, subscribables);
            return subscribables;
        };

        var scanForObservablesIn = function(model, subscribables){
            for (var parameter in model)
            {
                var typeOfData = getType(model[parameter]);
                switch(typeOfData)
                {
                    case "object": { scanForObservablesIn(model[parameter], subscribables); } break;
                    case "array":
                    {
                        var underlyingArray = model[parameter]();
                        underlyingArray.forEach(function(entry, index){ scanForObservablesIn(underlyingArray[index], subscribables); });
                    }
                        break;

                    default:
                    {
                        if(ko.isComputed(model[parameter]) || ko.isObservable(model[parameter]))
                        { subscribables.push(model[parameter]); }
                    }
                        break;
                }
            }
        };

        ko.bindingHandlers.chart = {
            init: function (element, valueAccessor, allBindingsAccessor, viewModel) {
                var allBindings = allBindingsAccessor();
                var chartBinding = allBindings.chart;
                var activeChart;
                var chartData;

                var createChart = function() {
                    var chartType = ko.unwrap(chartBinding.type);
                    var data = ko.toJS(chartBinding.data);
                    var options = ko.toJS(chartBinding.options);

                    chartData = {
                        type: chartType,
                        data: data,
                        options: options
                    };

                    activeChart = new Chart(element, chartData);
                };

                var refreshChart = function() {
                    chartData.data = ko.toJS(chartBinding.data);
                    activeChart.update();
                    activeChart.resize();
                };

                var subscribeToChanges = function() {
                    var throttleAmount = ko.unwrap(chartBinding.options.throttle) || 100;
                    var dataSubscribables = getSubscribables(chartBinding.data);
                    console.log("found obs", dataSubscribables);

                    ko.observableGroup(dataSubscribables)
                        .throttle(throttleAmount)
                        .subscribe(refreshChart);
                };

                createChart();

                if(chartBinding.options && chartBinding.options.observeChanges)
                { subscribeToChanges(); }
            }
        };


        return Component
            .extend({
                defaults : {
                    template : 'Ghratzoo_Covid/covid'
                },

                initObservable: function () {
                    this._super().observe(['labelsLine', 'confirmed', 'deaths', 'recovered', 'activeCases']);
                    const self = this;
                    covidService.getList().then(function (covids) {
                        let labels = [];
                        let confirmed = [];
                        let deaths = [];
                        let recovered = [];
                        let activeCases = [];

                        for (let i = 0; i < covids.length; i++) {
                            labels.push(covids[i].date.split(" ")[0]);
                            confirmed.push(covids[i].confirmed);
                            deaths.push(covids[i].deaths);
                            recovered.push(covids[i].recovered)
                            activeCases.push(covids[i].confirmed - covids[i].recovered - covids[i].deaths);
                        }

                        self.labelsLine(labels);
                        self.confirmed(confirmed)
                        self.deaths(deaths)
                        self.recovered(recovered)
                        self.activeCases(activeCases)
                        return covids;
                    });
                    return this;
                },

                initialize : function() {
                    this._super();

                    this.labelsLine = ko.observable([]);
                    this.confirmed = ko.observable([]);
                    this.deaths = ko.observable([]);
                    this.recovered = ko.observable([]);
                    this.activeCases = ko.observable([]);

                    this.CovidData = {
                        labels: this.labelsLine,
                        datasets: [
                            {
                                label: "Confirmed",
                                backgroundColor: "rgba(220,220,220,0.2)",
                                borderColor: "rgba(220,220,220,1)",
                                pointColor: "rgba(220,220,220,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointRadius: 0,
                                pointHighlightStroke: "rgba(220,220,220,1)",
                                data: this.confirmed
                            },
                            {
                                label: "Recovered",
                                backgroundColor: "rgba(0,255,0,0.2)",
                                borderColor: "rgba(0,255,0,1)",
                                pointColor: "rgba(0,255,0,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointRadius: 0,
                                pointHighlightStroke: "rgba(0,255,0,1)",
                                data: this.recovered
                            },
                            {
                                label: "Deaths",
                                backgroundColor: "rgba(255,0,0,0.2)",
                                borderColor: "rgba(255,0,0,1)",
                                pointColor: "rgba(255,0,0,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointRadius: 0,
                                pointHighlightStroke: "rgba(255,0,0,1)",
                                data: this.deaths
                            },
                            {
                                label: "Active",
                                backgroundColor: "rgba(0,0,255,0.2)",
                                borderColor: "rgba(0,0,255,1)",
                                pointColor: "rgba(0,0,255,1)",
                                pointStrokeColor: "#fff",
                                pointHighlightFill: "#fff",
                                pointRadius: 0,
                                pointHighlightStroke: "rgba(0,0,255,1)",
                                data: this.activeCases
                            }
                        ]
                    };
                }
            });
    });

(function(c) {
    var a = {
        timeoutMS: (1000 * 60 * 20),
        actionType: "ajaxpopup",
        actionParams: "",
        reloadMessage: null,
        dialogWidth: 464,
        adtString: "booklinkexpired/shown",
        ajaxURL: "/s/toolbox"
    };
    var b = {};
    var f = null;
    var d = {
        setup: function(g) {
            b = c.extend({}, a, g || {});
            this.cancelTimeout();
            f = window.setTimeout(function() {
                R9.RP.ResultsExpired.resultsTimeoutAction()
            }, b.timeoutMS)
        },
        takeAction: function() {
            if (b.actionType == "ajaxpopup") {
                this.ajaxAction()
            } else {
                if (b.actionType == "mouserefresh") {
                    this.mouseRefresh()
                }
            }
        },
        cancelTimeout: function() {
            if (f != null) {
                window.clearTimeout(f)
            }
            f = null
        },
        ajaxAction: function() {
            var g = b.actionParams + "&source=" + window.location.origin + window.location.pathname;
            jq.ajax({
                type: "POST",
                url: b.ajaxURL,
                data: g,
                dataType: "html",
                success: function(h) {
                    c(h).r9dialog({
                        hideTitle: true,
                        showCloseX: false,
                        width: b.dialogWidth
                    });
                    R9.Analytics.api.trackEvent(b.adtString)
                }
            })
        },
        mouseRefresh: function() {
            var g = this;
            c(document).one("mousemove", function() {
                if (b.reloadMessage) {
                    showRPSpinner(b.reloadMessage)
                }
                window.setTimeout(function() {
                    window.location.reload()
                }, 500)
            })
        }
    };
    R9.extend("RP.ResultsExpired", {
        start: function(g) {
            d.setup(g);
            return this
        },
        cancel: function() {
            d.cancelTimeout();
            return this
        },
        resultsTimeoutAction: function() {
            d.takeAction();
            return this
        }
    })
})(jq || jQuery);
R9.extend("Ads.SmartAd", {
    completedFirstRequest: false,
    slots: {
        R0: {
            child: null
        },
        R1: {
            child: null
        },
        M0: {
            child: null
        }
    },
    interval: -1,
    hasDARTResponse: function() {
        if (window.skipSmartAd) {
            return false
        }
        var a = Array.prototype.slice.call(jq("div.GPT")).filter(function(b) {
            var c = null;
            try {
                c = jq(b).find("iframe").contents().find("body #smtdiv")
            } catch (d) {}
            return c && c.length
        });
        return !!a.length
    },
    triggerDone: function() {
        for (var b in this.slots) {
            if (this.slots.hasOwnProperty(b)) {
                var a = this.slots[b].child;
                if (a) {
                    jq(a).trigger("child.streaming.done")
                }
            }
        }
    },
    listen: function() {
        if (window.showNewGPTAds) {
            window.showNewGPTAds()
        }
    },
    prepareRender: function(b) {
        var c = this,
            d = false,
            f = R9.Common.Utils,
            a = 1;
        b = b || 1;
        jq(window).bind("r9.streaming.done", jq.proxy(this.triggerDone, this));
        return f.after(b, f.throttle(a, function() {
            clearInterval(c.interval);
            c.interval = setInterval(function() {
                d = c.hasDARTResponse();
                if (d) {
                    c.completedFirstRequest = true;
                    clearInterval(c.interval);
                    displayGPTCallback()
                }
            }, R9.Ads.SmartAd.pollInterval)
        }))
    },
    resetRenderCount: function() {
        this.completedFirstRequest = false
    },
    adjustBannerContainerSize: function(a, d, c) {
        var b = R9.Ads.SmartAd.isExpanded ? "-international" : "";
        var f = this.getBannerNumber(c);
        d = d || "220";
        a = "150";
        jq(R9.Common.Utils.String.formatString("#displayAdSpanFrame{0} iframe", f)).css({
            height: a,
            width: d
        }).parent().addClass(R9.Common.Utils.String.formatString("largeBanner{0}{1}", f, b || "")).parents(R9.Common.Utils.String.formatString("#bannerad{0}", f)).css("width", d).css("min-height", a);
        jq(R9.Common.Utils.String.formatString("#rightads #bannerad{0} #displayAd{0}", f)).css("width", d).css("min-height", a);
        if (f == "1" && a == "280") {
            jq("#nrAds").css("margin-top", "0px")
        }
    },
    getBannerNumber: function(a) {
        var b = 1;
        if (R9.Ads.SmartAd.imageSlotEnabled && a) {
            b = a ? a.substring(a.length - 1) : 1
        }
        if (a === "M0") {
            b = 3
        }
        return parseInt(b, 10)
    },
    adjustments: {
        hideImageAd: function(a) {
            var b = R9.Ads.SmartAd.getBannerNumber(a);
            jq(R9.Common.Utils.String.formatString("#bannerad{0}", b)).slideUp()
        },
        pullUpTextAds: function() {},
        pullUpNextSibling: function() {
            jq("#bannerad1").css("margin-top", "-37px")
        },
        backfill: function(b) {
            var c = R9.Ads.SmartAd.getBannerNumber(b);
            var a = R9.Common.Utils.String.formatString("#displayAdSpanFrame{0} div:first-child", c);
            jq(a).css({
                left: -9
            });
            if (c === 1) {
                this.pullUpTextAds()
            } else {
                if (c === 0) {
                    this.pullUpNextSibling()
                }
            }
        }
    }
});
R9 = R9 || {};
var _isIE = navigator.appName.indexOf("Microsoft") > -1;
var _updatingResultsMessage = null;
var _currentPageNum = 1;
var _numrows;
var cancelAfterclick = false;
var usePopoverPagingTooltip = false;
var skipDetails = false;
if (typeof window.Streaming == "undefined") {
    window.Streaming = {
        done: true,
        stopClientTimeout: function() {}
    }
}

function setPage(f) {
    var d = R9.config.getBoolean("ui.infinitePaging", false);
    var b = f;

    function c() {
        if (!d) {
            window.scrollTo(0, 0);
            if (b == 2) {
                showPagingTooltip()
            }
        }
        R9.Analytics.api.trackEvent("page/" + b);
        initLikeWidgets()
    }
    if (d) {
        R9.ViewState.getInstance().addResultPageNumber(f)
    } else {
        R9.ViewState.getInstance().setIgnoreWindowScrollPositionOnce().addResultPageNumber(f)
    }
    if (window.ssUserAction) {
        updateDisplayA_ds(b);
        return ssUserAction("PG" + b, c, {
            pn: b - 1
        })
    } else {
        R9.ViewState.saveState()
    }

    function a() {
        if (!isNaN(b) && b >= 1 && b != _currentPageNum) {
            _currentPageNum = b;
            updateTable("paging");
            pgNums();
            c();
            hidemessage()
        }
    }
    waitForResults(a)
}

function clearPages() {
    _currentPageNum = 1
}

function getUpdateMessage(b) {
    var a = "";
    if (_updatingResultsMessage != null && _updatingResultsMessage.length > 0) {
        a += _updatingResultsMessage
    } else {
        if (b != null && b.length > 0) {
            a += b
        } else {
            a += "Updating results..."
        }
    }
    return a
}

function noop() {}

function refilter(b, d, g) {
    R9.globals.updating = true;
    showRPSpinner("", 0.95);
    Streaming.dbg("SHWMSG");
    hideAllTT();
    if (typeof hidePriceSelections == "function") {
        hidePriceSelections()
    }
    var h = new Date();

    function c() {
        R9.globals.updating = false;
        _updatingResultsMessage = null;
        R9.Analytics.api.trackEvent("filtertime&" + (new Date().getTime() - h.getTime()));
        hideRPSpinner();
        jq(document).trigger("event.refiltered")
    }
    if (window.ssUserAction) {
        updateDisplayA_ds("filter");
        return ssUserAction("FLT", c)
    }
    var f = b || jq.noop;

    function a() {
        h = new Date();
        clearPages();
        var j = parseInt(document.resultsPaging.rowsper.value);
        if (d == null || d) {
            setTop(0)
        }
        f();
        computeFiltered();
        if (j > _numrows) {
            fNumRows(j)
        }
        if (_lastsort == null) {
            updateTable(g)
        } else {
            if (_lastdirection != null) {
                _lastdirection = !_lastdirection
            }
            sortresults(_lastsort, true)
        }
        setTimeout(function() {
            R9.globals.updating = false;
            hideRPSpinner()
        }, 250);
        c();
        if (typeof resetResultCount == "function") {
            resetResultCount()
        }
    }
    waitForResults(a)
}

function sortorderclicked(a) {
    var b = jq(a).val();
    sortresults(b);
    R9.Analytics.api.trackEvent("sort/" + b);
    jq("#sortcontrols").removeClass("touched")
}

function sortresults(a) {
    R9.globals.updating = true;
    var f = new Date();
    if (typeof hidePriceSelections == "function") {
        hidePriceSelections()
    }
    showRPSpinner("", 0.95);
    if (window.ssUserAction) {
        var b = a.match(/(\w+)_([ab])$/);
        if (b) {
            a = b[1];
            _lastdirection = b[2] == "a"
        } else {
            if (_currentsortid == a) {
                _lastdirection = !_lastdirection
            } else {
                _lastdirection = true
            }
        }
        _currentsortid = a;
        R9.ViewState.getInstance().resetViewStatesOnSort();
        updateDisplayA_ds("sort");
        return ssUserAction("SRT" + a, function() {
            R9.globals.updating = false
        })
    }
    var c = a;

    function d() {
        var k = new Date();
        clearPages();
        setTop(0);
        c();
        var h = new Date();
        var j = 1000 - (h.getTime() - f.getTime());
        setTimeout(function() {
            R9.globals.updating = false;
            hideRPSpinner()
        }, ((j > 0) ? j : 1));
        _updatingResultsMessage = null;
        var g = new Date();
        R9.Analytics.api.trackEvent("sorttime&" + (g.getTime() - k.getTime()));
        updateTable("sorting")
    }
    updateDisplayA_ds("sort");
    waitForResults(d)
}

function showHotelDeals() {
    if (window.FilterList) {
        var b = jq(FilterList.options.sortControlsSelector);
        if (b.val() !== "feat_a") {
            b.val("feat_a");
            sortorderclicked(b)
        }
        if (FilterList.list.dealonly) {
            var a = FilterList.list.dealonly.elementNode;
            if (!jq(a).prop("checked")) {
                jq(a).click()
            }
        }
    }
    R9.Analytics.api.trackEvent("results/dealsrightrail/buttonclick")
}

function showHotelDealsNew() {
    if (window.FilterList) {
        var b = jq(FilterList.options.sortControlsSelector);
        if (b.val() !== "feat_a") {
            b.val("feat_a");
            sortorderclicked(b)
        }
        if (FilterList.list.dealonly) {
            var a = FilterList.list.dealonly.elementNode;
            jq(a).click()
        }
    }
    R9.Analytics.api.trackEvent("results/dealsrightrail/buttonclick")
}

function humanizeBookit(d, a) {
    var c = null;
    if (d && typeof(d) != "string") {
        c = jq(d);
        d = c.attr(a || "href")
    }
    if (!d || d.match(/&sc=/)) {
        return d
    }
    var b = d.match(/code=(.*)&/);
    if (b) {
        b = b[1].split(".")
    }
    if (!b || b.length <= 6) {
        return d
    }
    var f = (Math.abs(parseInt(b[0])) + Math.abs(parseInt(b[5]))) % 13242 + 1;
    d = d + "&sc=" + f;
    if (c) {
        c.attr(a || "href", d)
    }
    return d
}
var lastclickid = null;
var lastclickmsg = "";

function itemClicked(b, p, j, g, o, f, l) {
    humanizeBookit(f, l);
    g = g || "popup/resultclick";
    o = jq.extend({}, o);
    var k = (o.split);
    if (b && getResultID && o.resultid === undefined) {
        o.resultid = getResultID(b)
    }
    if (j) {
        o.pcode = j
    }
    var n = jq("#selectBox").is(":visible");
    var m = jq("#postClickXSell").is(":visible");
    if (!k && SHOW_AFTERCLICK_SECTION_WHEN_NO_POPUP && !m) {
        postClickNonBubbleAction(b, getResultID(b), j)
    } else {
        if (n && typeof toggleShowAfterClickSection == "function") {
            toggleShowAfterClickSection(true, b, j)
        }
    }
    if (window.hidePriceSelections && !cancelAfterclick) {
        hidePriceSelections()
    }
    hideVMBPopup();
    if (window.ViewState) {
        ViewState.update("clicked", b)
    } else {
        if (typeof _r != "undefined" && typeof _r[b] != "undefined") {
            _r[b]._vs = 1;
            if (lastclickid != null) {
                _r[lastclickid]._vs = 2
            }
        }
    }
    R9.ViewState.getInstance().addResultClicked(b).saveState();
    var h = (document.getElementById("popupAfterBooking") != null);
    if (!h) {
        var c = document.getElementById("msg" + b);
        var a = document.getElementById("resultmessage" + b);
        if (c) {
            c.style.display = _isIE ? "block" : "table-row"
        }
        if (a) {
            a.innerHTML = p
        }
        try {
            showprices(b, true)
        } catch (d) {}
    } else {
        if (!cancelAfterclick) {
            openbooking(null, p, j, b)
        }
    }
    lastclickmsg = p;
    lastclickid = b;
    R9.Analytics.api.trackEvent(g, o);
    return true
}

function hideVMBPopup() {
    if (jq("#vmbPositioner").is(":visible")) {
        jq(".detailopen").removeClass("detailopen");
        jq(".dropUp").removeClass("dropUp");
        jq("#vmbPositioner").addClass("hidden");
        R9.Analytics.api.trackEvent("vmbdropdown/hide")
    }
}

function openbooking(j, f, h, a) {
    var b = (j != null) ? j : "popupAfterBooking";
    var d = window.getResultID ? getResultID(a) : _r[a]._id;
    var c = document.getElementById(b);
    if (c != null && "FR" != h) {
        function g() {
            closebooking(b)
        }
        toggleFaderPane(true, g);
        jq("#" + b).show().css({
            top: jq(window).scrollTop() + 150,
            left: (jq(window).width() - jq("#" + b).width()) / 2
        });
        if (f != null) {
            jq("#popupbookmessage").html(f);
            f = "<span class='closearea'><a class='actionlink' href='javascript: closebooking()'>close</a> <img onclick='closebooking()' src='/res/images/close-x-white.gif?v=af73b5da36670a5aa27388bc820bc7e623cd3c23' border='0' width='11' height='11' /></span>" + f;
            jq("#popupAfterBooking > tbody > tr > td.title").html(f).children("span.fnf").css("display", "none")
        }
        jq("#fnflink > a").attr("href", "javascript: flightnotfound(" + a + ", '" + h + "')");
        if (typeof searchid != "undefined") {
            jq("#addtotripslink").attr("href", "javascript: R9.Analytics.api.trackEvent('afterclick/addtotrips');addResultToTrip('" + searchid + "', '" + d + "', 'addFlightToTrip" + a + "')")
        }
    }
}

function closebooking(c) {
    toggleFaderPane(false);
    var a = (c != null) ? c : "popupAfterBooking";
    var b = document.getElementById(a);
    if (b != null) {
        b.style.display = "none"
    }
}

function hideSearchBox() {
    toggleFaderPane(false);
    jq("#w11rp").unbind("click", hideSearchBox);
    jq("#popupSearch").hide()
}

function emailsuccess() {
    if (_lastEmailAttemptID != null) {
        try {
            itemClicked(_lastEmailAttemptID, "Result details emailed and saved to your search history.");
            _lastEmailAttemptID = null
        } catch (a) {}
    }
}
var pinnedResultList = new Array();

function getPinnedIDList() {
    var b = new Array();
    for (var a = 0; a < pinnedResultList.length; a++) {
        b.push(_r[pinnedResultList[a].id]._pid);
        if (_r[pinnedResultList[a].id]._pid != _r[pinnedResultList[a].id]._id) {
            b.push(_r[pinnedResultList[a].id]._id)
        }
    }
    return b.join(",")
}

function addFavorite(a, b, c) {
    R9.Common.Communication.ServerRequestService.addFavorite(a, function(d) {
        if (d.status === 0) {
            favorites.addFavorite(a, b);
            c && c()
        }
    })
}

function removeFavorite(a, b, c) {
    R9.Common.Communication.ServerRequestService.removeFavorite(a, function(d) {
        if (d.status === 0) {
            favorites.removeFavorite(a, b);
            c && c()
        }
    })
}

function initLikeWidgets() {
    R9.likeWidgets = R9.likeWidgets || [];
    var a = jq(".r9-like").filter(function(b) {
        return jq(this).data("r9Like") === undefined
    });
    a.each(function(c, d) {
        var b = "#" + jq(this).attr("id");
        R9.likeWidgets.push(new R9.Widgets.Like(jq(b), {
            favorites: window.favorites
        }))
    })
}

function initFavoriteWidgets() {
    var a = window.favorites,
        b;
    if (!a) {
        return
    }
    a.heartsList = [];
    b = jq(".r9-FavoriteToggle").filter(function(c) {
        return jq(this).data("r9FavoriteToggle") === undefined
    });
    b.each(function(c, d) {
        a.heartsList.push(new R9.Widgets.FavoriteToggle(jq(this)))
    })
}

function addPinned(a) {
    if (window.hideAllTT) {
        hideAllTT()
    }
    if (!window.ssUserAction) {
        return
    }
    R9.ViewState.getInstance().removeOpenedFlightDetails(a);
    ssUserAction("PIN: " + a, {
        pin: a + 1
    })
}

function removePinned(a) {
    if (window.hideAllTT) {
        hideAllTT()
    }
    if (!window.ssUserAction) {
        return
    }
    var b = R9.ViewState.getInstance();
    if (a == null) {
        b.resetOpenedFlightDetails();
        b.resetOpenedCarDetails()
    } else {
        b.removeOpenedFlightDetails(a)
    }
    var c = a == null ? "-all" : -a - 1;
    ssUserAction("UNPIN: " + c, {
        pin: c
    })
}

function localTTHidden() {
    toggleFaderPane(false, null)
}

function chkCompareToGroups(d) {
    var a = [],
        l = {};
    for (var c = 0; c < d.length; c++) {
        if (d[c].group == null || d[c].group.length == 0) {
            d[c].groupOK = true
        } else {
            var g = d[c].group.substr(0, d[c].group.indexOf("-")),
                h = parseInt(d[c].group.slice(d[c].group.indexOf("-") + 1)),
                f = c;
            if (l[g] == null) {
                for (var b = c + 1; b < d.length; b++) {
                    var m = d[b].group.substr(0, d[b].group.indexOf("-"));
                    if (m == g) {
                        var k = parseInt(d[b].group.slice(d[b].group.indexOf("-") + 1));
                        if (k < h) {
                            d[f].groupOK = false;
                            if (d[f].input != null) {
                                d[f].input.checked = false
                            }
                            f = b;
                            h = k
                        } else {
                            d[b].groupOK = false;
                            if (d[b].input != null) {
                                d[b].input.checked = false
                            }
                        }
                    }
                }
            }
        }
    }
    for (c = 0; c < d.length; c++) {
        if (d[c].groupOK = true) {
            a.push(d[c])
        }
    }
    return a
}

function popupBlockerMsg() {
    toggleFaderPane(true, null);
    loadDialog("popupWarning", "popupblockertooltipdiv", function() {
        showTT(document.getElementById("popupTTIPPos"), document.getElementById("popupWarning").innerHTML, "TL");
        jq("#tooltipdivimageholder").empty().append("<img align='left' style='margin-right: 8px' src='/images/a-pop-up-ani.gif'>");
        window.focus()
    })
}

function popupContinue() {
    toggleFaderPane(false, null);
    hideAllTT()
}

function isNumeric(c) {
    var b = "" + c;
    if (b.length == 0) {
        return false
    } else {
        if (b.length == 1 && (b.charAt(0) == "." || b.charAt(0) == "," || (b.charAt(0) == "-"))) {
            return false
        }
    }
    for (var a = 0; a < b.length; a++) {
        if ((b.charAt(a) >= "0" && b.charAt(a) <= "9") || b.charAt(a) == "." || b.charAt(a) == "," || (b.charAt(a) == "-" && a == 0)) {} else {
            return false
        }
    }
    return true
}

function getLeaveBehindFilterCell(b, c, a) {
    return ["<a href='javascript:" + c + ';R9.Analytics.api.trackEvent("leavebehind/' + (a || b.replace("'", "'")) + "\");'>", replaceArgs("Reset <b>{0} filter</b>", b), "</a>"].join("")
}

function getLeaveBehindFilterReasons() {
    var d = [];
    var a = {};
    var g = 0;
    var c = getFilteredOutReasons().reasons;
    for (var b = 0; b < c.length; b++) {
        var f = c[b];
        if (f.heading == null || f.heading == "") {
            continue
        }
        if (a[f.heading] == null) {
            g++;
            d[d.length] = getLeaveBehindFilterCell(f.heading, f.action, f.name) + " ";
            a[f.heading] = true
        }
    }
    if (g > 0) {
        if (g > 1) {
            d[d.length] = '<a class="resetAll" href=\'javascript: showLowest(false);R9.Analytics.api.trackEvent("leavebehind/all");\'>';
            d[d.length] = "Reset <b>all filters</b>";
            d[d.length] = "</a>"
        }
        return d.join("")
    }
    return null
}

function ui_select(a) {
    return a && document.resultUI && document.resultUI[a] || null
}

function monthDayYear(a) {
    if (!a) {
        a = new Date()
    }
    return (a.getMonth() - 0 + 1) + "/" + a.getDate() + "/" + a.getFullYear()
}

function queryAdsServer(a) {
    jq.get(a, function(b) {
        var g = jq("<div/>").html(b);
        var h = g.find("#sideads");
        var n = g.find("#topads");
        var c = g.find("#bottomads");
        var m = g.find("cmp2resultsads");
        var f = g.find("#bottomads_opt_header_tr1");
        var d = g.find("#bottomads_opt_header_tr2");
        var k = g.find("#bottomads_text_ads_td");
        var j = g.find("#bottomads_separator_td");
        var l = g.find("#topbannerads");
        jq("#topAdContainer").html(n).addClass("hideemptyfirst").hide();
        jq("#nrAdsAjax").html(h);
        if (f.length > 0) {
            jq("#bottomads_ads_tr").before(f);
            jq("#bottomads_opt_header_tr1").after(d)
        }
        if (k.length > 0) {
            if (!jq("#bottomads_text_ads_td").length) {
                jq("#bottomads_display_ad_td").before(k);
                jq("#bottomads_text_ads_td").after(j)
            } else {
                jq("#bottomads_text_ads_td").replaceWith(k)
            }
        }
        if (jq("#displayAdSpanFrame2").length > 0) {
            jq("#displayAdHide2").show()
        } else {
            jq("#displayAdHide2").hide()
        }
        jq(".resultRightRailXSell button").button();
        loadDisplayAds()
    })
}

function flippyDone() {
    jq("#flippyiframecontainer").hide(750);
    if (window.R9PBar) {
        R9PBar._stopTimer()
    }
}
var R9PBar = null;

function setupPBar(a) {
    var b = window.R9_PBartimer && jq("#progressDiv") || [];
    if (!b.length) {
        return
    }
    R9PBar = new R9_PBartimer(b, (a ? (a - 0) : 60000) + 5000)
}

function addKPackAdt(b, a) {
    a = jq.extend({}, a, {
        action: "vs"
    });
    if (window.SearchID && !a.searchid) {
        a.searchid = SearchID
    }
    jq.get("/vs/packagetour/" + b, a)
}

function allresultsloaded() {
    _ALLRESULTSLOADED = true;
    var a = document.getElementById("filtered_count");
    if (a) {
        a.innerHTML = _filtered.length
    }
    if (R9.config.getBoolean("ui.newdriveby", false)) {
        AjaxAlert.closeDriveByEmailAlertIfNoInteraction()
    }
    Streaming.dbg("ALR=true")
}

function flippyLoaded() {
    jq("#flippyblocker").hide()
}

function updateDisplayA_ds() {
    if (window.NoAds || R9_DisplayEds_JustHidden || !window.SearchID || window.local_displayEdOKToUpdate && !local_displayEdOKToUpdate()) {
        return
    }
    reloadBannerAds()
}

function waitForResults(c) {
    var a = 0;

    function b() {
        if (_ALLRESULTSLOADED) {
            c();
            jq(".slidedown").slideDown("slow");
            return
        } else {
            if (window.SearchType == "hotel" && a == 0) {
                R9.Analytics.api.trackEvent("impatienthoteluser")
            }
        }
        a++;
        if (a >= 40) {
            alert("Sorry, an error has occurred trying to update your results. Please send feedback if this problem persists.")
        } else {
            if (a <= 10) {
                window.setTimeout(b, 250)
            } else {
                window.setTimeout(b, 1000)
            }
        }
    }
    window.setTimeout(b, 1)
}

function doHide() {
    if (typeof hidePriceSelections === "function") {
        hidePriceSelections()
    }
    closeVmbDropdown()
}

function initSmartbox(k, c, d, a) {
    var b = 0;
    if (typeof d == "function") {
        var g = d;
        d = a;
        a = g
    }
    var h = {
        callbackWithNull: true,
        minWidth: 180,
        searchType: window.SearchType,
        timeout: window.smartyTypedelay
    };
    if (d) {
        jq.extend(h, d)
    }
    var j = h.callback;
    jq.each(c, function(f, m) {
        var l = jq(jq.isArray(m) && m[0] || m);
        if (l.length) {
            h.callback = function(n) {
                if (jq.isArray(m)) {
                    jq(m[1]).val(n ? n.id : "")
                }
                if (j) {
                    j.apply(this, n)
                }
                if (a) {
                    a.call(this, n, m)
                }
            };
            jq(l).smartbox(h).blur(function() {
                compare2chk(gradientDialogCleanup)
            });
            b++
        }
    });
    jq(window).unbind("lazyLoad." + k);
    if (c.length > b) {
        jq(window).bind("lazyLoad." + k, function() {
            initSmartbox(k, c, d, a)
        })
    }
    return b
}

function secondPhaseShow() {
    Streaming.showAllResults()
}

function clearTwoPhaseMessage() {
    Streaming.stopTwoPhase()
}

function expiredSearchAgain(a, c) {
    jq(document.body).css("cursor", "wait");
    if (window.Filters && window.Filters.saveState) {
        Filters.saveState("expired")
    }
    var b;
    if (a) {
        b = document.location.href;
        if (c) {
            b += "&nocache=1";
            document.location.replace(b)
        } else {
            document.location.reload()
        }
    } else {
        b = SearchURL;
        if (c) {
            b += "&nocache=1"
        }
        document.location.replace(b)
    }
}

function getResultID(a) {
    return _r[a]._id
}
var sharectl = null;

function showShareSection(resultID, hid, name, price, triptype, likeurl, action) {
    var data = "action=" + (action || "share") + "&searchid=" + SearchID + "&resultid=" + getResultID(resultID) + "&hid=" + hid;
    if (typeof window.Filters != "undefined") {
        data += "&fs=" + Filters.stateString()
    }
    hotelalertresid = resultID;
    hotelalerthid = hid;
    hotelalertname = name;
    if (resultID > -1) {
        R9.Social.FB.ensureAPILoaded();
        jq.ajax({
            type: "POST",
            url: "/s/toolbox",
            data: data + "&includecode=true",
            dataType: "xml",
            success: function(xmlobj) {
                var xml = jq(xmlobj),
                    code = xml.find("code").text();
                if (code && code.length) {
                    eval(code);
                    sharectl = new shareController()
                }
                jq("body").append(xml.find("html").text());
                sharectl.newShare(document.getElementById("sharelink" + resultID), hid, name, resultID, price, triptype, likeurl)
            },
            error: function(request, textStatus, error) {
                alert(textStatus + " " + error.toString())
            },
            cache: false
        })
    }
}

function showLowest(a) {
    if (a) {
        _lastdirection = true;
        _currentsortid = "pricesort"
    }
    var b = {};
    jq.each(FilterList.list, function(d, c) {
        if (d !== "priceType") {
            b[d] = c
        }
    });
    FilterList.resetFilters(b);
    R9.Analytics.api.trackEvent("leavebehind/all")
}

function validateJS(d) {
    if (R9 && R9.globals && typeof(R9.globals.fuseJS) != "undefined" && !R9.globals.fuseJS) {
        return
    }
    if (!d) {
        d = jq(document)
    }
    var c = d.find("#scripts");
    var b = [];
    var a = [];
    if (!c.length) {
        throw "#scripts div not found."
    }
    var f = R9 && R9.globals && R9.globals.adminAllowedScripts || [];
    d.find("script").each(function() {
        var h = this.id && "#" + this.id || this.src || this.text && ("'" + this.text.substr(1, 35).replace("", " ") + "...'") || this;
        var k;
        var g = false;
        for (k = 0; k < f.length; k++) {
            if (!this.src) {
                continue
            }
            var j = /^\/(.*)?\/([gim]*)$/.exec(f[k]);
            if (j) {
                var l = new RegExp(j[1], j[2]);
                if (l.test(this.src)) {
                    g = true;
                    break
                }
                continue
            }
            var m = this.src.lastIndexOf(f[k]);
            if (m != -1 && (m + f[k].length == this.src.length)) {
                g = true;
                break
            }
        }
        if (this.parentNode != c[0] && !g) {
            if (typeof console.log == "function") {
                console.log(h, c[0], identify(this.parentNode))
            }
            throw "All scripts must be in #scripts div, but" + h + " is in " + identify(this.parentNode)
        }
        if (this.src) {
            if (!g) {
                b.push(this.src)
            }
        } else {
            if (!this.id) {
                throw "All inline script tags must have ids, but" + h + " does not"
            } else {
                if (this.id != "econdascript") {
                    a.push(this.id)
                }
            }
        }
    });
    if (a.length > 1) {
        throw (a.length - 1) + " extraneous inline tags found: " + a.join(", ")
    }
    if (b.length > (SearchType == "car" && 10 || 6)) {
        throw "Too many (" + b.length + ") included scripts. Should be merged: " + b.join("")
    }
}

function completeInitialLoad() {
    if (window.productstartup) {
        window.productstartup()
    }
    Streaming.dbg("I=" + R9RsltCount + "; T=" + Streaming.lastPoll);
    if (LogScreenRes) {
        window.setTimeout(logResolutions, 4000)
    }
    jq(window).trigger("initialLoad")
}

function logResolutions() {
    try {
        R9.Analytics.api.trackEvent("res/" + screen.width + "x" + screen.height + "," + jq(window).width() + "x" + jq(window).height())
    } catch (a) {}
}

function attachMatrixHover() {
    var a = jq("#filterviewmatrix");
    if (!a.length) {
        return
    }
    jq("#filterviewmatrix").delegate("td.pricecell", "hover", function() {
        if (jq(this).html().match("\d")) {
            jq(this).toggleClass("hoverCell")
        }
    }).delegate("td.airlinecell", "hover", function() {
        jq("#filterviewmatrix td." + jq(this).attr("id")).toggleClass("hoverCol")
    }).delegate("td.stopslabel", "hover", function() {
        jq("#filterviewmatrix td." + jq(this).attr("id")).toggleClass("hoverRow")
    })
}

function attachFlexdatesHover() {
    var a = jq("#flexdatessection");
    if (!a.length) {
        return
    }
    jq("#flexdatessection").delegate(".data", "hover", function() {
        jq(this).toggleClass("hover");
        var b = jq(this).attr("id").split("-");
        jq.each(b, function(c, d) {
            jq(".dateheader." + d).toggleClass("hover")
        })
    })
}

function identify(b) {
    var c = "";
    b = jq(b);
    while (1) {
        if (!b[0] || b[0].tagName == "HTML") {
            break
        }
        if (b[0].id) {
            c = "#" + b[0].id + " " + c;
            break
        }
        var a = b[0].className.replace("s+", ".");
        c = b[0].tagName + (a ? "." + a : "");
        b = b.parent()
    }
    return c
}
R9.ajaxHistory = {
    lastHash: "",
    callback: null,
    initialize: function(a) {
        this.lastHash = window.location.hash;
        this.callback = a;
        setTimeout(R9.ajaxHistory.checkHash, 300)
    },
    ignoredChange: function(a) {
        var b = this.callback;
        this.callback = false;
        try {
            a.call();
            this.lastHash = window.location.hash
        } finally {
            this.callback = b
        }
    },
    checkHash: function() {
        var a = window.location.hash;
        var b = this.lastHash;
        if (a != b && b != undefined) {
            this.lastHash = a;
            if (this.callback) {
                this.callback.call(this)
            }
        }
        setTimeout(R9.ajaxHistory.checkHash, 300)
    }
};

function destroyPopupSearch() {
    var a = jq("#popupSearch"),
        b = a.data();
    if (b.r9popover) {
        a.r9popover("destroy")
    } else {
        if (b.r9dialog) {
            a.r9dialog("destroy")
        }
    }
    return a
}
var hdetCall = null;

function showHotelDetailPopup(a, c) {
    var d = "hid=" + a + "&page=" + c + "&inline=1&rsrc=hpopup&searchid=" + searchid;
    if (hdetCall != null) {
        try {
            hdetCall.abort()
        } catch (b) {}
    }
    hdetCall = jq.ajax({
        type: "POST",
        url: "/hotel/overlaydetails.vtl",
        data: d,
        dataType: "html",
        success: function(g) {
            try {
                jq("#hotelDetailsPopup").css({
                    width: "978px",
                    top: "0",
                    bottom: "0"
                });
                jq("#hotelDetailsPopup").html(g);
                jq("#hotelDetailsPopup").r9dialog({
                    width: 1010,
                    top: "0",
                    bottom: "0",
                    useMaxHeight: true,
                    dialogClass: "hotelDetailTall",
                    wrapperClass: "hotelDetailWrapper",
                    viewPortClass: "hotelDetailViewport",
                    modalBackgroundClass: "hotelDetailBackground",
                    contentClass: "hotelDetailContent"
                }).show();
                R9.Hotels.Details.setShowHashTag(false);
                R9.Hotels.Details.setInline(true);
                hdetCall = null
            } catch (f) {}
        },
        error: function(g, h, f) {
            hdetCall = null
        },
        cache: false
    })
}

function loadPopupSearch(a) {
    loadSection(jq("#popupSearchLazy"), function() {
        a.apply(destroyPopupSearch())
    }, {
        action: "searchpopup"
    })
}

function loadDialog(c, b, a) {
    if (jq("#" + c).length) {
        a()
    } else {
        ssAJAX("/s/toolbox", {
            action: "tpl",
            t: b
        }, a)
    }
}

function loadSection(b, a, d) {
    if (typeof a == "string") {
        var c = d;
        d = {
            action: a
        };
        a = c
    }
    if (b.is(".lazy")) {
        ssUserAction("LZLD", function() {
            if (a) {
                a.apply(b, arguments)
            }
            b.removeClass("lazy")
        }, d)
    } else {
        if (typeof a == "function") {
            a.apply(b)
        }
    }
}

function showMoreReasons(a) {
    jq(".reviewreasons").hide();
    var c = jq("#firstreview_" + a).html();
    var d = "hotel.freetextreview.show." + c;
    if (c != null && c != "") {
        var b = jq("#revdetail_" + c).html();
        if (b != null && b.length < 10) {
            detailReviewClicked(a, c, d)
        }
    }
    jq("#reviewreasons_" + a).r9dialog({
        width: 780,
        position: ["center", 100]
    }).show()
}

function bindSelectTextOnFocus() {
    focusedElement = null;
    jq("input.selectTextOnFocus").on("focus", function() {
        if (focusedElement == jq(this)) {
            return
        }
        focusedElement = jq(this);
        setTimeout(function() {
            focusedElement.select()
        }, 50)
    })
}

function showAndHideFilterPopup() {
    var a = jq("#filterdiv"),
        b = a.offset();
    b.left += a.width() + 30;
    b.top = b.top - (jq("#popupFilterInfo").height() / 2) + (a.height() / 2 + 10);
    jq("#popupFilterInfo").offset(b);
    jq("#popupFilterInfo").delay(2000).show().delay(10000).fadeOut("slow")
}

function popupFilters() {
    jq("#filterblock").addClass("filterpopped")
}

function showOneFilter(a) {
    if (jq("#filterblock").hasClass("filterpopped")) {
        if (!jq("#nrLeftFilter").hasClass("secopen")) {
            jq("#nrLeftFilter").addClass("secopen").addClass("fs_open_" + a)
        }
    }
}

function popupFilterBack() {
    jq("#nrLeftFilter").removeClass("secopen").removeClass(function(b, a) {
        return (a.match(/fs_open_\S+/g) || []).join(" ")
    })
}

function popdownFilters() {
    popupFilterBack();
    jq("#filterblock").removeClass("filterpopped")
}

function openBookingLink(myHref, myTarget) {
    if (myHref.indexOf("javascript") == 0) {
        eval(myHref)
    } else {
        if (myTarget == "_self") {
            var h = myHref;
            window.setTimeout(function() {
                window.location.href = h
            }, 400)
        } else {
            window.open(myHref, myTarget.replace(":", ""))
        }
    }
}

function popupsearchsubmit() {
    R9.Analytics.api.trackEvent("toolbox/changesearch/searchagain");
    jq("#getratesbutton").prop("disabled", true);
    var c = generateSearchUrl(document.searchagain);
    if (c != null) {
        var b = jq("#seo");
        if (b.is("div")) {
            var a = jq("#popupSearch");
            if (a.is("div")) {
                destroyPopupSearch()
            }
        }
        R9.RP.ResultsExpired.cancel();
        R9App.AppInstance.navigate(c, {
            beforeNavigate: destroyPopupSearch
        });
        return false
    }
    return true
}

function compare2chk(f, d) {
    if (R9.CompareTo.isBehaviorOfVertical(a())) {
        d = d || {};
        var c = null;
        if (document.inlinesearchagain) {
            c = "inlinesearchagain"
        }
        if (d.formName) {
            c = d.formName
        }
        var h = R9.CompareTo.View.getUniqueId(g(c));
        var b = R9.CompareTo.Controller.get(h);
        if (typeof h !== "undefined" && typeof b != "undefined") {
            if (window.inlineFormCmp2EnabledWithFrontDoorPlacements) {
                b.setShowOnFrontDoor()
            }
            b.refresh()
        }
        return true
    }

    function a() {
        if (window.SearchType && !window.StartTab) {
            if (SearchType.slice(-1) != "s") {
                StartTab = SearchType + "s"
            } else {
                StartTab = SearchType
            }
        }
        return StartTab
    }

    function g(j) {
        if (!j) {
            j = a()
        }
        return document[j] || document.searchagain
    }
}

function cmp2resetItems() {
    var c = new R9.CompareTo.Window.Opener();
    var a = 0;
    var d = jq(".cmp2item:not(.compareToInputHidden) input");
    var b = (window.BrowserConfig) ? BrowserConfig.getNumber("maxCheckedItems", 5) : 5;
    jq.each(d, function() {
        var f = jq(this);
        var g = f.prop("defaultChecked");
        if (g == true) {
            a++
        }
        if (f.prop("checked")) {
            c.close(f.val());
            R9.Utils.WindowOpener.closeWindow(f.val())
        }
        if (a > b) {
            f.prop("checked", false)
        } else {
            f.prop("checked", g)
        }
    })
}

function checkStudentCabin(a) {
    if (a.value == "e") {
        toggleStudent(true)
    } else {
        toggleStudent(false)
    }
}

function toggleStudent(a) {
    if (a) {
        student("0")
    } else {
        jq("#student").val("0");
        jq("#student_link").hide();
        jq("#non_student_link").hide()
    }
}

function student(a) {
    jq("#student").val(a);
    setMetaCookie("isStudent", a == 1 ? "true" : "false");
    if (a == "1") {
        jq("#student_link").hide();
        jq("#non_student_link").show()
    } else {
        jq("#non_student_link").hide();
        jq("#student_link").show()
    }
    compare2chk()
}

function compareChecked(a, b) {
    b = b || jq.noop;
    setMetaCookie(a.value, a.checked ? "true" : "false", b)
}

function fbSend(b, a) {
    R9.XDM.remotePostAjax(AjaxReg.remoteHost + "/s/run/toolbox/sendtofb", jq("#facebook_msg").serialize() + "&accessToken=" + b + "&userId=" + a, function(c) {
        closefb()
    }, function(c) {
        alert("ERROR! Please try again!")
    })
}

function fbShare() {
    var a = {
        perms: "publish_actions",
        success: fbSend
    };
    R9.Social.FB.login(a);
    return false
}

function closefb() {
    jq("#facebook_msg").hide();
    jq("#facebook_posted").show();
    if (window.gradientDialogCleanup) {
        gradientDialogCleanup()
    }
}

function twitterShare() {
    var d = "https://twitter.com/share";
    var f = jq("#tweet").val();
    f = encodeURI(f);
    var c = window.location.pathname;
    c = escape(c);
    d += "?text=" + f;
    d += "&url=null" + c;
    var a = "twitterdotcom";
    var b = "width=600,height=400";
    window.open(d, a, b);
    sharectl.closeCreateForm()
}

function limitTwitterChars() {
    var a = jq("#tweet").val().length;
    if (a > 140) {
        jq("#tweet").val(jq("#tweet").val().substring(0, 140))
    }
}

function submitforemail(d) {
    var c = d ? document.getElementById(d) : document.emailform;
    if (!validateEmail(c.from.value)) {
        try {
            c.from.focus()
        } catch (b) {}
        alert("Please enter a valid email address in the 'From' field");
        return false
    }
    var a = c.tolist.value.split(",");
    if (c.tolist.value.length == 0 || a.length == 0 || !validateEmail(a[0])) {
        try {
            c.tolist.focus()
        } catch (b) {}
        alert("Please enter a valid email address in the 'To' field");
        return false
    }
    if (c.subject.value.length == 0) {
        try {
            c.subject.focus()
        } catch (b) {}
        alert("Please enter a subject for the email");
        return false
    }
    return true
}

function shareemail(k, a) {
    var a = a || "";
    if (submitforemail((a ? "shareemailform" + a : null))) {
        var b = a ? jq("#shareemailform" + a) : jq("form[name=emailform]");
        var d = true;
        var h = b[0].tolist.value;
        var l = h.split(",").length;
        var c = R9.globals.tripsaliases || "";
        var g = [];
        if (c.length > 0) {
            g = c.split(",")
        }
        var j = false;
        var f = 0;
        for (f = 0; f < g.length; f++) {
            if (h.indexOf(g[f]) != -1) {
                j = true;
                break
            }
        }
        if (j) {
            if (l <= 1) {
                l = 0
            }
            if (typeof k != "undefined" && k == true) {
                d = false;
                showTripsAjaxReg("#sendemail")
            } else {
                addResultToTrip(b[0].searchid.value, b[0].resultid.value, "tripadded" + a);
                jq("#tripadded" + a).show()
            }
        }
        if (d && l > 0) {
            sharetheemail(b, a)
        } else {
            if (d) {
                jq("#emailform" + a).hide();
                jq("#emailsent" + a).show()
            }
        }
    }
}

function sharetheemail(c, d) {
    var b = c.serialize();
    var a = "/s/emailresult";
    if (typeof window.Filters != "undefined") {
        b += "&fs=" + Filters.stateString()
    }
    R9.XDM.remotePostAjax(AjaxReg.remoteHost + a, b, function(f) {
        jq("#emailform" + d).hide();
        jq("#emailsent" + d).show();
        jq("#emailsentmessage" + d).html(f).show();
        if (window.gradientDialogCleanup) {
            gradientDialogCleanup()
        }
    }, function(g, h, f) {
        alert(h + ": " + f)
    })
}

function closeAllDialogs() {
    jq(".ui-dialog-content").r9dialog("close");
    jq(".ui-dialog-content").r9popover("close")
}

function showTripsAjaxRegAfterClick(a) {
    jq("body").unbind("click.hidepricesel");
    if (!AjaxReg.alreadyRegistered) {
        showTripsAjaxReg(a)
    } else {
        openSaveToMyTripsDialogAfterClick(searchId, resultId, showPrice, providerCode)
    }
}

function showTripsAjaxReg(g, f, a, b, d, c) {
    if (!AjaxReg.alreadyRegistered) {
        AjaxReg.regtype = "trips";
        AjaxReg.searchid = "";
        AjaxReg.ui.register(function() {
            openSaveToMyTripsDialog(f, a, b, d, c)
        })
    } else {
        openSaveToMyTripsDialog(f, a, b, d, c)
    }
}

function openSaveToMyTripsDialogAfterClick(d, a, b, c) {
    jq("body").unbind("click.hidepricesel").bind("click.hidepricesel", hidePriceSelections);
    openSaveToMyTripsDialog(d, a, b, c)
}

function openSaveToMyTripsDialog(f, a, b, d, c) {
    if (typeof closeVmbDropdown === "function") {
        closeVmbDropdown()
    }
    if (!checkTripsTos()) {
        showTripsTosBubble(f, a, b, d);
        return
    }
    R9.XDM.remotePostJSON(AjaxReg.remoteHost + "/s/run/saveToMyTrips/chooseTrip", {
        searchId: f,
        flightType: c
    }, function(h) {
        if (h.success) {
            var g = jq(h.html);
            g.r9dialog({
                width: 510
            }).find("#saveToMyTripsTabs").tabs();
            g.r9dialog("option", "close", function() {
                g.r9dialog("destroy");
                g.remove()
            });
            jq("a").blur();
            jq("#saveToMyTripsResultId").val(a);
            jq("#saveToMyTripsShowPrice").val(b);
            jq("#saveToMyTripsProviderCode").val(d)
        } else {
            alert(h.error)
        }
    }, function() {
        alert("There was an unexpected error. Please try again.")
    })
}

function showSaveToMyTripsControls(b, a) {
    hideSaveToMyTripsControls();
    jq("#" + b).addClass("selectedTrip");
    jq("#saveToMyTripsTripId").val(b);
    jq("#saveToMyTripsTripName").html(a);
    jq("#saveToMyTripsControls").show()
}

function hideSaveToMyTripsControls() {
    jq(".saveToMyTripsTrip").removeClass("selectedTrip");
    jq("#saveToMyTripsTripId").val("");
    jq("#saveToMyTripsTripName").html("");
    jq("#saveToMyTripsControls").hide();
    jq("#saveToMyTripsDuplicate").hide()
}

function saveToMyTrips() {
    R9.XDM.remotePostJSON(AjaxReg.remoteHost + "/s/run/saveToMyTrips/save", {
        searchId: jq("#saveToMyTripsSearchId").val(),
        resultId: jq("#saveToMyTripsResultId").val(),
        showPrice: jq("#saveToMyTripsShowPrice").val(),
        providerCode: jq("#saveToMyTripsProviderCode").val(),
        encodedTripId: jq("#saveToMyTripsTripId").val()
    }, function(a) {
        if (a.success) {
            jq("#saveToMyTrips").html(a.html)
        } else {
            if (a.duplicate) {
                hideSaveToMyTripsControls();
                jq("#saveToMyTripsDuplicate").html(a.error).show()
            } else {
                alert(a.error)
            }
        }
    }, function() {
        alert("There was an unexpected error. Please try again.")
    })
}

function saveToNewTrip() {
    jq("#saveToMyTripsTripId").val("");
    saveToMyTrips()
}

function checkTripsTos() {
    var a = false;
    jq.ajax({
        type: "POST",
        url: "/k/run/tripsTos/check",
        async: false,
        dataType: "json",
        success: function(b) {
            if (b.success) {
                a = b.ok
            } else {
                alert(b.error)
            }
        },
        error: function() {
            alert("There was an unexpected error. Please try again.")
        },
        cache: false
    });
    return a
}

function showTripsTosBubble(d, a, b, c) {
    jq.ajax({
        type: "POST",
        url: "/k/run/tripsTos/showTosBubble",
        data: {
            searchId: d,
            resultId: a,
            showPrice: b,
            providerCode: c
        },
        dataType: "html",
        success: function(g) {
            var f = jq(g);
            f.r9dialog({
                width: 440
            });
            f.r9dialog("option", "close", function() {
                f.r9dialog("destroy");
                f.remove()
            });
            jq("a").blur()
        },
        error: function(g, h, f) {
            alert(g.statusText)
        },
        cache: false
    })
}

function sendTripsTosResponse(f, d, a, b, c) {
    if (f) {
        jq.ajax({
            type: "POST",
            url: "/k/run/tripsTos/accept",
            dataType: "json",
            success: function(g) {
                if (g.success) {
                    closeAllDialogs();
                    openSaveToMyTripsDialog(d, a, b, c)
                } else {
                    alert(g.error)
                }
            },
            error: function() {
                alert("There was an unexpected error. Please try again.")
            },
            cache: false
        })
    } else {
        jq.ajax({
            type: "POST",
            url: "/k/run/tripsTos/showTosRejected",
            dataType: "html",
            success: function(g) {
                jq("#tosBubble").html(g)
            },
            error: function(h, j, g) {
                alert(h.statusText)
            },
            cache: false
        })
    }
}

function inlinelearnmore(a, b) {
    var c = "provider=" + b;
    jq.ajax({
        type: "POST",
        url: "/s/run/toolbox/learnmoreinline",
        data: c,
        dataType: "html",
        success: function(f) {
            try {
                showTT(document.getElementById(a), f, "BL")
            } catch (d) {}
        },
        error: function(f, g, d) {
            alert(g)
        },
        cache: false
    })
}

function stopPropagation(b, a) {
    b = jq.Event(b);
    b.stopPropagation(a)
}
var cancelPropagation = stopPropagation;

function stopPropagationAndDefault(a) {
    a = jq.Event(a);
    a.preventDefault();
    a.stopPropagation()
}

function showtoolbox() {
    jq("#showtoolboxlink").hide();
    jq("#hidetoolboxlink, .toolboxActions").show();
    setMetaCookie("showToolbox." + SearchType, "true")
}

function hidetoolbox() {
    jq("#hidetoolboxlink, .toolboxActions").hide();
    jq("#showtoolboxlink").show();
    deleteMetaCookie("showToolbox." + SearchType, "true")
}

function postClickNonBubbleAction(a, g, d) {
    if (jq("#splitBookingInfo").is(":visible")) {
        return
    }
    if (window.SearchType == "hotel") {
        postClickHotelNonBubbleAction(a, g, d);
        return
    }
    var f = false;
    if (jq(".oneway").length) {
        f = true
    }
    var h = {
        searchid: searchid,
        resultid: g,
        localidx: a,
        pcode: d
    };
    var b = {
        searchid: searchid,
        isoneway: f
    };

    function c() {
        jq.get("/s/run/" + R9.globals.vertical + "/postclicknonbubble", h, function(m) {
            if (m.length > 100) {
                closeAfterClickBubble();
                jq("body").append(m);
                var j = jq("#postClickXSell");
                var l = {
                    neverFocus: true,
                    hideTitle: true,
                    isFixed: true,
                    modal: true,
                    position: ["center", 50],
                    width: 675,
                    title: j.attr("title")
                };
                var k = j.find("button");
                k.button().removeClass("ui-button-gray");
                j.r9dialog(l);
                R9.Analytics.api.trackEvent("afterclick/impression");
                jq(".mytrips-btn").on("click", function(q) {
                    var o = jq(this),
                        p = o.data("searchid"),
                        s = o.data("resultid"),
                        n = o.data("localidx"),
                        r = o.data("type");
                    closeAfterClickBubble();
                    if (!o.data("isanon")) {
                        R9.Analytics.api.trackEvent("afterclick/addtotrips");
                        openSaveToMyTripsDialog(p, s, n, null, r)
                    } else {
                        R9.Analytics.api.trackEvent("afterclick/addtotrips/anon");
                        showTripsAjaxReg("#postClickXSell", p, s, n, null, r)
                    }
                    q.preventDefault()
                })
            }
        })
    }
    if (SIMPLE_AFTER_CLICK_CROSS_SELL && window.SearchType == "flight") {
        jq.get("/s/run/flight/crosssellhotel", b, function(j) {
            if (!jq(j).hasClass("hotelXSellErrorMessage")) {
                displayCrossSell(j)
            } else {
                c();
                R9.Analytics.api.trackEvent("afterclickxsell/xsellfailed")
            }
        })
    } else {
        c()
    }
}

function closeAfterClickBubble() {
    var a = jq("#postClickXSell");
    if (a.length) {
        a.r9dialog("destroy").remove()
    }
}

function displayCrossSell(c) {
    closeAfterClickBubble();
    var b = {
        wrapperClass: "promoDialog",
        minWidth: 740,
        modalOpacity: 0.46,
        top: 150,
        close: function() {
            a = this.element.find("#postClickXSell, #postClickXSellStars");
            var g = a.data("name");
            R9.Analytics.api.trackEvent("afterclickxsell/" + g + "/close")
        }
    };
    var f = jq("<div></div>");
    f.html(c).newDialog(b);
    var a = jq("#postClickXSellStars");
    var d = a.data("name");
    setUpVSLogging("afterclickxsell/" + d);
    jq(".hotelSearchLink", "#postClickXSell, #postClickXSellStars").click(function(g) {
        R9.Analytics.api.trackEvent("afterclickxsell/" + d + "/searchButton")
    });
    jq(".promoImage", "#postClickXSell, #postClickXSellStars").click(function(h) {
        var g = jq(this).data("bgidx");
        R9.Analytics.api.trackEvent("afterclickxsell/" + d + "/promoImage/bg" + g)
    });
    jq(".cityImage", "#postClickXSellStars").click(function(g) {
        R9.Analytics.api.trackEvent("afterclickxsell/" + d + "/cityImage")
    });
    jq(".starprice", "#postClickXSellStars").click(function(h) {
        var g = jq(this).data("starlevel");
        R9.Analytics.api.trackEvent("afterclickxsell/" + d + "/starprice/" + g)
    })
}

function bindHotelCrossSellUpdateEvent() {
    jq("body").on("xsell.update", function() {
        showHotelCrossSell()
    })
}

function setUpVSLogging(a) {
    R9.Analytics.api.trackEvent(a + "/impression")
}

function findIndex(a) {
    return jq(a).parents(".xsellItem").data("index") + 1
}

function cleanUpBorder() {
    window.setTimeout("doBorderCleanUp()", 410)
}

function doBorderCleanUp() {
    jq("#filterblock, #resbody").css("min-height", "");
    var a = Math.max(jq("#resbody").outerHeight(), jq("#filterblock").outerHeight());
    jq("#filterblock, #resbody").css("min-height", a)
}

function showTaxFeeBubble(b, a, c) {
    jq("#" + b).tipTip({
        showImmediately: true,
        content: jq("#alertbubble .box").html(),
        delay: 100
    })
}

function showTaxFeeBubbleOverlay(c, b, f) {
    var a = jq("#" + c).offset().left;
    var d = jq("#" + c).offset().top;
    b = b || 45;
    f = f || 80;
    a = a - b;
    d = d - f;
    jq("#alertbubble").css({
        top: d,
        left: a
    }).fadeIn()
}

function showTaxFeeBubbleHID(b, a, c) {
    jq("#bubbleanchor" + b).tipTip({
        showImmediately: true,
        content: jq("#inlinealertbubble .box").html(),
        delay: 100
    })
}

function hideTaxFeeBubble() {
    jq("#alertbubble").hide();
    jq("#inlinealertbubble").hide();
    jq("#nightlywfeebubble").hide();
    jq("#pricetypebubble").hide()
}

function showNightlyWFeeBubbleHID(b, a, c) {
    jq("#bubbleanchorwfees" + b).tipTip({
        showImmediately: true,
        content: jq("#nightlywfeebubble .box").html(),
        delay: 100
    })
}

function showPriceTypeTooltip(a, b) {
    jq("#pricetypelabel").tipTip({
        showImmediately: true,
        content: jq("#pricetypebubble .pricetypebubble").html(),
        delay: 100
    })
}

function showBookDirectTooltip(b, a, d) {
    var c = jq(b);
    c.tipTip({
        showImmediately: true,
        content: c.data("msg"),
        delay: 100,
        baseClass: "book-directly-tooltip-content"
    })
}

function showFullDisclaimerTextSection() {
    jq(".fullPriceGuaranteeDisclaimer").toggle()
}

function updateIntentMediaPageId() {
    window.console && console.log("updateIntentMediaPageId ", window.IntentMedia && window.IntentMedia.Event);
    if (window.IntentMedia && IntentMedia.page_id_updated) {
        IntentMedia.page_id_updated()
    }
}

function doSeoRedirectToCity(a) {
    window.open(jq(a).data("redirect"), "_self")
}

function closeVmbDropdown() {
    var a = jq(".vmbdropdown.detailopen");
    if (a.length > 0) {
        jq("#vmbPositioner").addClass("hidden");
        a.removeClass("detailopen")
    }
}

function onVmbDropdown(a) {
    var g = jq(this).data("resultid");
    var k = jq(this);
    var f = jq("#vmbPositioner");
    k.removeClass("dropUp");
    if (f.is(":visible") && g == f.data("detailopen")) {
        jq("#vmbPositioner").addClass("hidden");
        k.removeClass("detailopen");
        R9.Analytics.api.trackEvent("vmbdropdown/hide")
    } else {
        var d = jq(this).parent().parent().find(".vmbsitelistwrapper");
        var c = jq(this).parent().parent().find(".buylink");
        var b = c.offset();
        var j = c[0].getBoundingClientRect();
        var h = (j.top + d.height()) > jq(window).height();
        if ((j.left + d.width()) > jq(window).width()) {
            b.left -= (d.width() - c.width())
        }
        if (h) {
            b.top -= d.outerHeight();
            k.addClass("dropUp")
        } else {
            b.top += jq(c).height()
        }
        f.css({
            top: Math.round(b.top) + "px",
            left: Math.round(b.left) + "px"
        });
        f.html(d.html()).removeClass("hidden");
        f.data("detailopen", g);
        k.addClass("detailopen");
        R9.Analytics.api.trackEvent("vmbdropdown/show");
        jq("body").one("click", function() {
            jq("#vmbPositioner").addClass("hidden");
            k.removeClass("detailopen")
        });
        jq(window).off("updateDisplayDone.vmb").on("updateDisplayDone.vmb", function() {
            jq("#vmbPositioner").addClass("hidden");
            k.removeClass("detailopen");
            R9.Analytics.api.trackEvent("vmbdropdown/hide")
        })
    }
    if ((R9.config.getBoolean("ui.paymentfee.penalise.box.enabled", false) || R9.config.getBoolean("ui.providerbucketsort.enabled", false)) && typeof paymentPenaltyTooltipMessage != "undefined") {
        jq("li.paymentPenalty").tipTip({
            position: "right",
            content: paymentPenaltyTooltipMessage,
            delay: 100
        })
    }
    a.stopPropagation(true)
}

function attachInlineMultibook() {
    var a = jq("#vmbPositioner");
    if (a.length == 0) {
        a = jq("<div class='hidden' id='vmbPositioner'></div>").appendTo("body")
    }
    jq("#listbody,#vmbPositioner,#leftResultListContent").delegate(".resultInlineMulti .allInlineItems", "click", function(b) {
        b.stopPropagation();
        jq(this).parents(".resultInlineMulti").toggleClass("opened")
    }).delegate(".vmbdropdown", "click", onVmbDropdown).delegate(".dealCompareInfo", "click", function(b) {
        jq(this).find("a.dealsinresult").each(function(c) {
            openBookingLink(this.rel, this.target);
            jq(this).addClass("visited");
            R9.Analytics.api.trackEvent("results/dealtag/click")
        });
        b.stopPropagation(true)
    }).delegate(".verticalMultibook .pricerange", "click", function(b) {
        jq(this).find("a.dealsinresult").each(function(c) {
            openBookingLink(this.rel, this.target);
            jq(this).addClass("visited");
            R9.Analytics.api.trackEvent("results/bigprice/click")
        });
        b.stopPropagation(true)
    }).delegate(".resultInlineMulti .item, .bestProviderSite", "click", function(b) {
        jq(this).find("a.dealsinresult").each(function(c) {
            openBookingLink(this.rel, this.target);
            jq(this).addClass("visited");
            R9.Analytics.api.trackEvent("results/inline/click");
            jq("#vmbPositioner").addClass("hidden")
        });
        b.stopPropagation(true)
    })
}

function showPriceAlertSaved(alertid, error) {
    var mydata = {
        action: "farealertsaved",
        searchid: SearchID,
        alertid: alertid
    };
    var savedalert;
    jq.ajax({
        type: "POST",
        url: "/s/toolbox",
        data: mydata,
        dataType: "xml",
        success: function(xmlobj) {
            try {
                var alertUC = jq("#alertUpsellContent");
                if (alertUC.data("dialog") != null) {
                    alertUC.data("dialog").close()
                }
                var xml = jq(xmlobj);
                var code = xml.find("code").text();
                var html = xml.find("html").text();
                if (code != null && code.length > 0) {
                    eval(code)
                }
                jq("#showalertlinkrow").hide();
                jq("#showalertsavedlinkrow").show();
                html = jq(html);
                var options = {
                    title: html.find(".title").text(),
                    width: 240,
                    spinner: false,
                    contentClass: "createAlertPadding",
                    titleClass: "createAlertTitlePadding",
                    buttons: [{
                        text: "OK",
                        click: function() {
                            this.close()
                        }
                    }]
                };
                var toogleNode = jq("#" + window.FilterList.options.toggleGroupLinkId);
                var editAlertLink = jq("#editalertlink");
                if (AjaxReg.regtype !== "driveby" && editAlertLink.size() == 1 && toogleNode.hasClass("filterGroupOpened")) {
                    options.position = "#editalertlink";
                    options.modal = false
                }
                html.newDialog(options);
                if (typeof(savedalert) != "undefined" && typeof(savedalert.savedalertid) != "undefined") {
                    jq("#editalertlink").attr("href", "/alerts?action=prepop&alertid=" + savedalert.savedalertid)
                } else {
                    jq("#editalertlink").attr("href", "/alerts")
                }
                if (alertid == "-2" && (typeof(error) != "undefined")) {
                    AjaxAlert.showEmailAlertError(error)
                } else {
                    jq("#alerterrorrow").hide();
                    jq("#alertsuccessrow").show()
                }
            } catch (ignored) {}
        },
        error: function(request, textStatus, error) {
            alert(textStatus)
        },
        cache: false
    })
}

function postClickHotelNonBubbleAction(a, c, b) {
    var d = {
        searchid: searchid,
        resultid: c,
        localidx: a,
        pcode: b
    };
    jq.get("/s/run/" + R9.globals.vertical + "/postclicknonbubble", d, function(g) {
        if (g.length > 100) {
            if (jq("#postClickXSell").length > 0) {
                jq("#postClickXSell").r9dialog("destroy").remove()
            }
            jq("body").append(g);
            var f = {
                neverFocus: true,
                closeOnEscape: true,
                hideTitle: true,
                isFixed: false,
                modal: true,
                position: ["center", 50],
                width: 692,
                title: jq("#postClickXSell").attr("title")
            };
            jq("#postClickXSell button").button();
            jq("#postClickXSell button").removeClass("ui-button-gray");
            jq("#postClickXSell").r9dialog(f).r9dialog("option", "close", function(h) {
                jq("#vmbPositioner").addClass("hidden");
                jq(".bookitselect.vmbdropdown.detailopen").removeClass("detailopen")
            });
            R9.Analytics.api.trackEvent("hotel/afterclick/impression");
            jq(".similarHotel-details").delegate(".resultInlineMulti .item", "click", function(h) {
                jq(this).find("a.dealsinresult").each(function(j) {
                    openBookingLink(this.rel, this.target);
                    jq(this).addClass("visited");
                    R9.Analytics.api.trackEvent("results/afterclick-similar/click")
                });
                h.stopPropagation(true)
            }).delegate(".vmbdropdown", "click", onVmbDropdown)
        }
    })
}

function showPagingTooltip() {
    if (!window.R9Skin && jq.cookie("pgmsgshown") != "y" && !window.FILTER_CLICKED && !(window.currentview == "map") && jq("#resultUI").is(":visible")) {
        if (usePopoverPagingTooltip === true) {
            var a = [435, 120];
            var d = parseInt(jq("#resbody").offset().top) + 140;
            var b = parseInt(jq("#resbody").offset().left) - 20;
            a = [b, d];
            jq('<div><div class="pagingToolTip popover"><span>Selecting filter options on the left will narrow results to just a few.</span></div></div>').r9popover({
                position: a,
                title: "Find results faster...",
                width: 350
            });
            jq(".ui-dialog-titlebar").before("<div class='pagingToolTipIcon'></div>")
        } else {
            var c = {
                x: -6,
                y: 70
            };
            showTT(document.getElementById("topOfFilter"), "<div class='pagingToolTip'><span class=\"hideTTX\" onclick=\"hideTTType('CT')\"></span><div><b>Find results faster</b></div><div>Selecting filter options on the left will narrow results to just a few.</div></div>", "CL", c);
            jq("body").one("click", function() {
                hideAllTT()
            })
        }
        jq.cookie("pgmsgshown", "y");
        R9.Analytics.api.trackEvent("showpgtooltip")
    }
}

function showCubaDisclaimer(c, a, g) {
    var b = null;
    if (typeof g !== "undefined" && g.target) {
        var h = jq(g.target).closest(".maindatacell").find(".pricerange");
        if (h && h.length > 0) {
            b = h
        }
    }
    var f = '<p>For more information, visit: <a target="_blank" href="%URL%">%URL%</a><br />%PHONE%</p>';
    if (c && c.length > 0) {
        c = c.replace(/(^https?:\/\/(www\.)?|^)/, "http://www.")
    }
    if (a && a === "-") {
        a = ""
    }
    f = f.replace(/%URL%/g, c);
    f = f.replace(/%PHONE%/g, a);
    jq(".ui-dialog.cubaDisclaimer").r9popover("destroy").remove();
    var d = jq('<div><div class="cubaDisclaimerContent">' + f + "</div></div>");
    d.r9popover({
        autoFocus: false,
        modal: false,
        position: b,
        multiPopovers: true,
        at: "auto",
        title: null,
        clazz: "cubaDisclaimer"
    })
}
if (!R9_Objects) {
    var R9_Objects = []
}

function R9_PBartimer(b, a) {
    this.selector;
    this.fullTime = 45000;
    this.updateInterval = 750;
    this.linear = false;
    this._currentValue;
    this._elapsedTime;
    this._startTime;
    this._timerID;
    this.callbacks;
    this._constructor = function(c, d) {
        this._id = R9_Objects.length;
        R9_Objects[this._id] = this;
        this.selector = c;
        jq(this.selector).progressbar({
            value: 0
        });
        if ((d - 0) > 0) {
            this.fullTime = (d - 0);
            this._startTimer()
        }
        this.callbacks = []
    };
    this.addCallback = function(c) {
        this.callbacks.push(c)
    };
    this._checkup = function() {
        this._currentValue = this.valueDefault
    };
    this.getPosition = function(c) {
        if (this.linear) {
            return c
        }
        var d = function(h, f, j, g) {
            h /= g;
            h--;
            return j * (h * h * h + 1) + f
        };
        return d(c, 0, 1, 1)
    };
    this.setPercentage = function(c) {
        if (c == null || c < 0) {
            c = 0
        }
        if (c > 100) {
            c = 100
        }
        jq(this.selector).progressbar("option", "value", c);
        this._currentValue = c;
        this.callbacks.forEach(function(d) {
            d(c)
        })
    };
    this.getValue = function() {
        return this._currentValue
    };
    this.timerCallback = function() {
        this._elapsedTime = new Date().getTime() - this._startTime;
        if (this._elapsedTime >= this.fullTime) {
            this.setPercentage(100);
            this._stopTimer()
        } else {
            var d = this.getPosition(this._elapsedTime / this.fullTime);
            var c = Math.round(d * 100);
            this.setPercentage(c);
            this._setNextTimeout(this._delayInterval())
        }
    };
    this._delayInterval = function() {
        return 150
    };
    this._setNextTimeout = function(c) {
        this._timerID = window.setTimeout("R9_Objects[" + this._id + "].timerCallback()", c)
    };
    this._startTimer = function() {
        if (this._timerID == null) {
            this._elapsedTime = 0;
            this._startTime = new Date().getTime();
            var c = this._delayInterval();
            this._setNextTimeout(c)
        }
    };
    this._stopTimer = function() {
        if (this._timerID != null) {
            window.clearTimeout(this._timerID);
            this._timerID = null
        }
    };
    this._constructor(b, a)
}
var BubbleIsOpen = false;
var R9LastSelectionShown = -1;
var checkSelectBoxX = false;
R9.extend("dialog.bubble", {
    defaultParams: {
        rowSelector: ".bubbleBookingOption",
        containerSelector: "#bubbleholder",
        linkSelector: "a.booklink",
        delegationFlagParamName: "delegationFlags",
        splitBookingWarningSelector: "#splitBookingWarning",
        mapBubbleOffset: {
            left: -30,
            top: -50
        }
    },
    bindPriceEvents: function(c, f, b) {
        if (!c) {
            var c = this.defaultParams.rowSelector
        }
        if (!b) {
            var b = this.defaultParams.containerSelector
        }
        if (!f) {
            var f = this.defaultParams.linkSelector
        }
        var a = jq(b);
        if (!a.data("stopPropagationFlagged")) {
            a.click(function(g) {
                stopPropagation(g)
            });
            a.data("stopPropagationFlagged", true)
        }
        if (!this._isDelegationFlagged(b, c, f)) {
            var d = this;
            a.delegate(c, "click", function(g) {
                d._bookingRowClickEvent(this, f)
            });
            this._flagDelegation(b, c, f)
        }
        a.find(".restricted").click(function(g) {
            stopPropagation(g)
        }).tipTip()
    },
    acceptSplitBookingWarning: function(a, b) {
        if (!a) {
            var a = this.defaultParams.containerSelector
        }
        jq("#splitBookingWarning").hide();
        jq("#splitBookingInfo").show();
        jq(a + " .truncate").ellipsisTooltip();
        jq.cookie("splitBookWarningAccepted" + b, true, {
            path: "/"
        });
        R9.Analytics.api.trackEvent("splitbooking/okbutton")
    },
    attachDisclaimerTipTip: function(a, b) {
        var c = jq(a || "#bubbleholder .totalpricelbl");
        if (!c.length) {
            return
        }
        that = this;
        c.each(function() {
            var f = that._getDisclaimerTipType(this);
            var d = this;
            loadTT("#ttip" + f, function() {
                jq(d).tipTip(jq.extend({
                    delay: 0,
                    content: jq("#ttip" + f).text()
                }, b || {}))
            })
        })
    },
    showPriceSelections: function(a, g, c) {
        if (isNonAvail) {
            getrates(a, jq("#listbody #tbd" + a).find(".ui-button"));
            return
        }
        if (!g) {
            g = "bubble"
        }
        var f = this;
        var b = jq("#buttonReference");
        var d = !b.length || b.hasClass("lazy");
        ssUserAction("BUBL", function() {
            var h = "auto",
                j = ".priceAnchor" + a;
            if (g == "splitbook") {
                R9.Analytics.api.trackEvent("splitbooking/openbubble");
                h = "left"
            }
            f._postProcessResponse();
            if (!jq("#priceAnchor" + a).is(":visible")) {
                j = jq(".priceAnchor" + a + ":visible")[0]
            } else {
                if (jq(".selectButton" + a).length > 0) {
                    j = ".selectButton" + a
                }
            }
            if (j === undefined || j.length === 0) {
                j = jq(".CSS_OPENFLEX_HIDDEN_RESULT .selectButton" + a)
            }
            jq(f.defaultParams.containerSelector).r9popover("destroy").r9popover(jq.extend({
                autoFocus: false,
                modal: false,
                position: j,
                at: h,
                title: jq.trim(jq(f.defaultParams.containerSelector + " .dialogTitle").text()),
                clazz: "hackerDialog"
            }, c || {}));
            if (R9.RP && R9.RP.Flights && R9.RP.Flights.BaggageFeesTooltip && R9.RP.Flights.BaggageFeesTooltip.prototype && (typeof(R9.RP.Flights.BaggageFeesTooltip.prototype.init) === "function")) {
                R9.RP.Flights.BaggageFeesTooltip.prototype.init()
            }
        }, {
            action: g,
            index: a,
            lazy: d
        })
    },
    showPriceSelectionsOnMap: function(a, d, g, b) {
        if (!g) {
            return
        }
        var f = "left";
        if (g.left.x - Math.round(jq("div.fixedWidthOuter").offset().left) > 450) {
            var f = "right"
        }
        var c = this;
        this.showPriceSelections(a, d, jq.extend({
            position: document,
            at: f,
            open: function(h, j) {
                jq(h.target).r9popover("widget").css(c.getBubblePositionOnMap(g))
            }
        }, b))
    },
    getBubblePositionOnMap: function(b) {
        var a = Math.round(b.right.x + this.defaultParams.mapBubbleOffset.left);
        if (b.left.x - Math.round(jq("div.fixedWidthOuter").offset().left) > 450) {
            a = Math.round(b.left.x + this.defaultParams.mapBubbleOffset.left - this.getBubbleWidth())
        }
        return {
            left: a,
            top: Math.round(this.defaultParams.mapBubbleOffset.top + b.left.y)
        }
    },
    getBubbleWidth: function() {
        return jq(this.defaultParams.containerSelector).width() + jq(this.defaultParams.containerSelector).parent().find(".ui-popover-arrow").width()
    },
    hideBookingBubble: function() {
        jq(this.defaultParams.containerSelector).r9popover("close")
    },
    _getDisclaimerTipType: function(b) {
        var d = jq(b).parent().attr("class").split(" ");
        for (var a in d) {
            var c = jq.trim(d[a]).match(/^splitPriceTaxes_([A-Z]{2,3}$)/);
            if (!c) {
                continue
            }
            return c[1]
        }
        return "DT"
    },
    _bookingRowClickEvent: function(b, c) {
        var a = jq(b);
        if (a.is("span.disclaim")) {
            e.stopPropagation();
            return
        }
        a = a.hasClass("customer-service-by") ? a.prev() : a;
        a.addClass("visited");
        a.find(c).each(function() {
            if (typeof this.onclick == "function") {
                this.onclick()
            }
            openBookingLink(this.rel, this.target)
        })
    },
    _isDelegationFlagged: function(a, c, d) {
        var b = jq(a).data(this.defaultParams.delegationFlagParamName);
        if (!b || typeof b[c] == "undefined" || typeof b[c][d] == "undefined") {
            return false
        }
        return true
    },
    _flagDelegation: function(a, c, d) {
        var b = jq(a).data(this.defaultParams.delegationFlagParamName) || {};
        if (typeof b[c] == "undefined") {
            b[c] = {}
        }
        b[c][d] = true;
        jq(a).data(this.defaultParams.delegationFlagParamName, b)
    },
    _postProcessResponse: function() {
        var b = jq("#bubbleholder");
        if (window.canBuyOnKAYAK && !b.find(".splitBubbleIntro").length) {
            b.find("button").css("width", window.canBuyOnKAYAKWidth)
        }
        var a = ".bottomlinks a.actionlink, #selectBoxHotelDetails a";
        b.find(a).each(function() {
            if (jq(this).attr("href").indexOf("detailClicked") > -1) {
                jq(this).click(function() {
                    b.r9popover("close")
                })
            }
        });
        b.find(".totalpricelbl[title]").tipTip({
            delay: 0
        })
    }
});
if (!window.OldStyleBubble) {
    OldStyleBubble = false
}

function getBubbleWidth() {
    return (SearchType == "hotel" || SearchType == "vacation") && !window.HIDE_TOTAL ? 412 : 325
}

function showSelectionBox() {
    if (checkSelectBoxX) {
        var b = jq("#bubbleholder"),
            c = b.outerWidth(),
            a = getBubbleWidth();
        if (c != a) {
            b.css("left", b.offset().left - (c - a))
        }
    }
}

function showPriceSelections(a, g, h) {
    if (!g) {
        R9.dialog.bubble.showPriceSelections(a, h)
    } else {
        var f = null;
        var c;
        var d;
        if (g != null && jq(g).size() == 1) {
            f = g
        } else {
            var b = "priceAnchor" + a;
            f = document.getElementById(b)
        }
        if (f != null) {
            var j = jq(f).offset();
            c = {
                x: j.left,
                y: j.top
            };
            d = {
                x: c.x + f.offsetWidth,
                y: c.y + f.offsetHeight
            }
        } else {
            c = {
                x: 0,
                y: 0
            };
            d = {
                x: 0,
                y: 0
            }
        }
        showPriceSelectionsXY(a, c, d, h)
    }
}

function showPriceSelectionsXY(a, b, d, f) {
    if (!f || f.length == 0) {
        f = "bubble"
    }
    if (jq("#selectBoxContainer").css("display") != "none") {
        hidePriceSelections();
        if (a == R9LastSelectionShown) {
            return
        }
    }
    BubbleIsOpen = true;
    R9LastSelectionShown = a;
    if (navigator.appVersion.indexOf("MSIE 6.") != -1) {
        jq("iframe:not(.donothide)").css("visibility", "hidden")
    }
    var c = false;
    ssUserAction("BUBL", function() {
        aftershowPriceSelectionsXY(getResultID(a), b, d)
    }, {
        action: f,
        index: a,
        lazy: c
    });
    if (!OldStyleBubble) {
        hideAllTT()
    }
}

function aftershowPriceSelectionsXY(g, a, b) {
    var c = {
            x: 15,
            y: -50
        },
        f = Math.round(c.y + a.y),
        d = 0;
    if (a.x - Math.round(jq("div.fixedWidthOuter").offset().left) > 450) {
        setPointDirection(false);
        d = Math.round(a.x - getBubbleWidth());
        checkSelectBoxX = true
    } else {
        setPointDirection(true);
        d = Math.round(c.x + b.x);
        checkSelectBoxX = false
    }
    var h = jq("#selectBoxContainer").css({
        top: f,
        left: d
    });
    if (window.canBuyOnKAYAK && !h.find(".splitBubbleIntro").length) {
        h.show();
        h.find("button").css("width", window.canBuyOnKAYAKWidth);
        if (msie(7)) {
            jq("#selectBoxContainer").width(500)
        }
    } else {
        h.show()
    }
}

function hidePriceSelections() {
    R9.dialog.bubble.hideBookingBubble();
    BubbleIsOpen = false;
    jq("#cmp2Popup").children("tr.dynamic").remove();
    jq("#cmp2Popup").children("tr.popupCmp2").show()
}

function bindPriceEvents() {
    R9.dialog.bubble.bindPriceEvents("tr.bubbleBookingOption")
}

function setPointDirection(b) {
    var a = jq("#selectBoxContainer");
    if (b) {
        a.removeClass("dialog_translucent_rightptr");
        a.addClass("dialog_translucent_leftptr")
    } else {
        a.removeClass("dialog_translucent_leftptr");
        a.addClass("dialog_translucent_rightptr")
    }
}

function toggleShowAfterClickSection(b, a, f) {
    if (!SHOW_AFTERCLICK_SECTION_IN_POPUP) {
        return
    }
    if (b) {
        var h = getResultID(a);
        var j = {
            searchid: searchid,
            resultid: h,
            localidx: a,
            pcode: f
        };
        var c = 250;
        var d;
        var g = getAfterClickRequest(j, c, d);
        if (g && typeof g == "object") {
            jq.ajax(g)
        }
    } else {
        jq("#afterclickcontent").remove();
        jq("#selectBoxContainer").removeClass("afterclick");
        if ((SearchType == "flight" || SearchType == "hotel")) {
            jq("#selectBoxalert").html("")
        }
    }
}
var showAfterclickSimilars = false;

function getAfterClickRequest(mydata, alertboxwidth, existingalertobj) {
    if (!jq("#selectBox").is(":visible")) {
        return null
    }
    var reqobj = null;
    if (showAfterclickSimilars) {
        reqobj = {
            type: "POST",
            url: "/s/run/toolbox/simafterclick",
            dataType: "html",
            data: mydata,
            success: function(html) {
                var cleanHtml = html.replace(/^\s+|\s+$/g, "");
                if (cleanHtml.length > 0) {
                    jq("#selectBoxXSellBubble").html(cleanHtml)
                }
                if (window.gradientDialogCleanup) {
                    window.setTimeout(gradientDialogCleanup, 200)
                }
                R9.Analytics.api.trackEvent("impression/afterclick/similarhotels")
            },
            error: function(request, textStatus, error) {
                alert(textStatus)
            },
            cache: false
        }
    } else {
        jq.ajax({
            type: "GET",
            url: "/s/flightdetails/afterclick",
            data: mydata,
            dataType: "xml",
            success: function(xmlobj) {
                var xml = jq(xmlobj),
                    code = xml.find("code").text(),
                    html = xml.find("html").text();
                if (code != null && code.length > 0) {
                    eval(code)
                }
                jq("#afterClickWrapper").html(html);
                jq("#selectBoxContainer").addClass("afterclick");
                if (msie(7)) {
                    var w = jq("#selectBoxalert").width() + 490;
                    jq("#selectBoxContainer div.dialog_content").css({
                        width: w + "px"
                    });
                    jq("#selectBoxContainer div.dialog_bottom").css({
                        width: (w + 12) + "px"
                    });
                    jq("#selectBoxContainer").css({
                        width: (w + 12) + "px"
                    })
                }
                if (window.gradientDialogCleanup) {
                    window.setTimeout(gradientDialogCleanup, 200)
                }
            },
            error: function(request, textStatus, error) {
                alert(textStatus)
            },
            cache: false
        })
    }
    return reqobj
}
ViewState = {
    _state: {},
    update: function(c, a, b) {
        if (b == null && {
                clicked: 1,
                removed: 1
            }[c]) {
            b = true
        }
        if (a == null) {
            if (b) {
                this.clear(c)
            }
            delete this._state[c];
            delete this._state["last" + c];
            return
        }
        this._state[c] = jq.merge(this._state[c] || [], [a]);
        if (b) {
            this.clear("last" + c)
        }
        this._state["last" + c] = [a];
        if (b) {
            c == "removed" ? ssUserAction("RM", {
                pn: _currentPageNum - 1
            }) : this.set(c)
        }
    },
    applyClass: function(a, b) {
        jq.each(this._state[a] || [], function() {
            jq("#tbd" + this)[b ? "removeClass" : "addClass"](a)
        })
    },
    clear: function(a) {
        this.set(a, true);
        if (a) {
            this._state[a] = this._state["last" + a] = null
        } else {
            this._state = {}
        }
    },
    set: function(a, b) {
        this.apply(a, b);
        this.apply("last" + a, b)
    },
    apply: function(a, c) {
        if (a) {
            this.applyClass(a, c);
            return
        }
        var b = this;
        jq.each(this._state, function(d) {
            b.applyClass(d, c)
        })
    }
};

function ssUserAction(b, a, c) {
    if (a && !c && typeof a != "function") {
        c = a;
        a = null
    }
    if (typeof affiliatePageUpdate == "function") {
        affiliatePageUpdate(b, c)
    }
    if (!Streaming.done && Streaming.delay < 2000) {
        Streaming.delay *= 1.5
    }
    if (c && c.pin) {
        ViewState.update("pinned", c.pin > 0 ? c.pin - 1 : null)
    }
    ViewState.interacted = true;
    return ssRefreshResults(null, null, null, a, b, c, function() {
        jq("#resbody").removeClass("resbodyupdating");
        hidemessage();
        Streaming.dbg("HDMSG")
    })
}

function ssRefreshResults(p, j, s, n, h, g, d) {
    var q = (p == null) ? "" : "&poll=" + p + "&final=" + j + "&updateStamp=" + s;
    var l = window._currentsortid || "";
    if (Streaming.pollTimer) {
        Streaming.dbg("CNCL: " + Streaming.pollTimer);
        window.clearInterval(Streaming.pollTimer);
        Streaming.pollTimer = null
    }
    if (l && !window._lastdirection) {
        l = "-" + l
    }
    var f = document.resultUI && jq(ui_select("landmark")) || jq("lmlist");
    var r = document.resultUI && jq(ui_select("landmarkreturn")) || jq("lmlistreturn");
    var m = jq.extend(g, {
        lm: f.attr("value"),
        lmname: f.find(":selected").text(),
        lm2: r.attr("value"),
        lmname2: r.find(":selected").text(),
        c: document.resultsPaging && document.resultsPaging.rowsper.value || 15,
        s: l,
        searchid: SearchID,
        itd: ViewState.interacted && "1" || "",
        poll: p || -1,
        seo: jq("#isIndexable").length > 0
    });
    if (m.seo != undefined && m.seo) {
        var a = jq("meta[name=seoFilterType]").attr("content");
        var k = jq("meta[name=seoFilterName]").attr("content");
        var c = jq("meta[name=seoFilterValue]").attr("content");
        if (c != undefined && c != "") {
            m = jq.extend(m, {
                filterType: a
            });
            m[k] = c
        }
    }
    var o;
    if (window.Filters) {
        if (Filters.size) {
            m.fs = Filters.stateString()
        }
        if (Filters.matchprice) {
            m = jq.extend(m, Filters.matchprice)
        }
        Filters.matchprice = null
    }
    if (window.ssUserActionParams) {
        o = ssUserActionParams(m)
    }
    if (o) {
        m = jq.extend(m, o)
    }
    var b = ssRefreshResultsUrl(h, p);
    return ssAJAX(b + q, m, n, h, d)
}

function ssRefreshResultsUrl(c, a) {
    var b = "/s/jsresults?ss=1";
    if (isSeoNewHotelListPage) {
        b = "/charm/seo/city-hotels-list-filter?ss=1";
        if (c) {
            if (c == "FLT") {
                b = "/charm/seo/city-hotels-list-filter?ss=1"
            } else {
                if (c.indexOf("SRT") == 0) {
                    b = "/charm/seo/city-hotels-list-sort?ss=1"
                } else {
                    if (c.indexOf("PG") == 0) {
                        b = "/charm/seo/city-hotels-list-page?ss=1"
                    }
                }
            }
        }
    } else {
        if (a) {
            b = "/s/jspoll?ss=1"
        } else {
            if (c) {
                if (c == "FLT") {
                    b = "/s/jsfilter?ss=1"
                } else {
                    if (c.indexOf("SRT") == 0) {
                        b = "/s/jssort?ss=1"
                    } else {
                        if (c.indexOf("PG") == 0) {
                            b = "/s/jspage?ss=1"
                        }
                    }
                }
            }
        }
    }
    return b
}

function ssAJAX(d, h, c, g, a) {
    var b = new Date().getTime() - Streaming.startTime;
    window.POLLID = b;
    if (!g && h) {
        g = h.action
    }
    if (h) {
        h.ua = g
    }
    h[R9.ViewState.getInstance().options.urlStateRequestKey] = R9.ViewState.getUrlStateString();
    h.streaming = (Streaming.done) ? "false" : "true";
    if (!d.match(/&poll=\d+[&$]/) && g !== "recentlyviewed") {
        h[R9.ViewState.getInstance().options.saving.requestKey] = R9.ViewState.getStateString()
    }
    var f = jq.ajax({
        type: "post",
        url: d,
        dataType: "html",
        data: h,
        complete: function(j) {
            ssCompleteRq({
                pid: b,
                searchid: window.searchid
            }, a, g, j)
        },
        success: function(j) {
            ssApplyResults(j, {
                pid: b,
                searchid: window.searchid
            }, c, g)
        },
        error: function(l, j, k) {
            if ((l.status === 0 || l.readyState === 0) && (j != "error" || k == "")) {
                return
            }
            if (R9.config.getBoolean("ui.error.logging.streamer", false)) {
                R9.UILogger.logAjax("streaming", l, j, k, function() {
                    if (location.href.lastIndexOf("reload=true") == -1) {
                        location.href = location.href + (location.href.lastIndexOf("?") != -1 ? "&" : "?") + "reload=true"
                    }
                })
            } else {
                Streaming.err(new Error("ajax error: rs=" + (l && l.status ? l.status : "unknown") + " st=" + (j || "unknown") + " err=" + (k || "unknown")))
            }
        }
    });
    if (!h || h.poll == null || h.poll < 0) {
        Streaming.dbg((g || "PICK") + ": " + b + " >");
        if (!jq.browser.msie) {
            jq(document.body).addClass("wait")
        }
    }
    return f
}

function ssCompleteRq(b, c, d, a) {
    if (b.pid == window.POLLID) {
        if (c) {
            c(b.pid, d, a)
        }
        window.POLLID = null
    }
    if (!jq.browser.msie) {
        jq(document.body).removeClass("wait")
    }
}

function ssApplyResults(g, d, b, f) {
    var a = d.pid;
    var c = d.searchid;
    if (g.match("<html>")) {
        R9.RP.ResultsExpired.resultsTimeoutAction()
    }
    try {
        var j = (f || "Poll #" + Streaming.pollCount) + " [" + a + "]";
        Streaming.dbg(j + "<:-");
        if (window.POLLID != a) {
            Streaming.dbg("LCKD PollID" + a + ";" + window.POLLID);
            R9.Analytics.api.trackAutoEvent("ssapply/wrongpid/" + Streaming.getdbg());
            return
        }
        if (window.searchid != c) {
            Streaming.dbg("LCKD SearchID" + c + ";" + window.searchid);
            R9.Analytics.api.trackAutoEvent("ssapply/wrongsearch/" + Streaming.getdbg());
            return
        }
        if (!ViewState._initialized) {
            Streaming.dbg("AWA");
            jq(window).bind("updateDisplayDone.initial", function() {
                window.POLLID = a;
                ssApplyResults(g, d, b, f)
            });
            R9.Analytics.api.trackAutoEvent("ssapply/notinit/" + Streaming.getdbg());
            return
        }
        jq(window).unbind("updateDisplayDone.initial");
        updateTopLevelElements(g);
        if (b) {
            b(f, g, a)
        }
    } catch (h) {
        if (window.R9Admin && (!Streaming.alertedPollError || Streaming.done)) {
            R9.utils.log("Admin message - Error in update: " + Streaming.stack(h, "Error in update:"), h);
            Streaming.alertedPollError = true
        }
        R9.Analytics.api.trackAutoEvent("ssapply/except/" + h.message + "/" + Streaming.getdbg())
    }
    if (f != "cluster") {
        Streaming.nextPoll()
    }
}
var SkipUpdateDataAttrName = "data-attr-skip-update";

function updateTopLevelElements(b, a) {
    var c = document.createElement("div");
    c.innerHTML = b;
    b = jq(c);
    b.children(".exec.first").each(evalExec);
    b.children(":not(.exec)").each(function(d, g) {
        var f = g.id ? document.getElementById(g.id) : null;
        if (f) {
            if (f.getAttribute(SkipUpdateDataAttrName) !== null) {
                f.removeAttribute(SkipUpdateDataAttrName)
            } else {
                f.innerHTML = g.innerHTML
            }
        } else {
            if (!a) {
                document.body.appendChild(g)
            }
        }
    });
    b.children(".exec:not(.first)").each(evalExec);
    return b
}

function evalExec(c) {
    if (typeof c == "number") {
        c = this
    }
    try {
        var a = (c.innerText || c.textContent);
        if (!a) {
            return
        }
        a = a.replace(/([^\r])\n/, "$1\r\n");
        jq.globalEval(a)
    } catch (b) {
        if (typeof Streaming.err === "function") {
            Streaming.err(b, false, a)
        } else {
            if (window.R9Admin) {
                console.log(b)
            }
        }
    }
}

function updateDisplay(d, b, c, f, a) {
    _r = _filtered = null;
    _ALLRESULTSLOADED = true;
    ViewState.apply();
    R9RsltCount = window.R9TotalResultCount = d;
    R9FltrdCount = b;
    resultCount = jq(".hotelresult").length - jq(".inlineOpaque").length || jq(".mapListEntry").length;
    if (c) {
        _currentsortid = c;
        _lastdirection = typeof f == "string" ? f == "true" : f
    }
    if (a) {
        _currentPageNum = a
    }
    if (Streaming.done) {
        finalUpdateDisplay()
    } else {
        if (window.R9Admin) {
            updateDOMInfo()
        }
    }
    if (!ViewState._initialized) {
        Streaming.dbg("INI (" + d + ")")
    }
    ViewState._initialized = true;
    jq(window).trigger("updateDisplayDone");
    if (d > 0 && window.BOOMR && typeof utSearchFirstResultDone != "undefined" && !utSearchFirstResultDone) {
        window.markUserTime("ut_search_first_result");
        utSearchFirstResultDone = true;
        BOOMR.addVar("search_poll_count", window.Streaming.pollCount);
        if (window.Streaming.pollCount == 0 && window.Streaming.done) {
            BOOMR.addVar("search_cached", 1)
        } else {
            BOOMR.addVar("search_cached", 0)
        }
    }
}

function finalUpdateDisplay() {
    if (typeof YAPTA !== "undefined") {
        setTimeout(generateYaptaButtons, 1)
    }
    if (window.initCompleted) {
        initCompleted()
    }
    if (typeof hideFlightDealsEnabled == "function" && hideFlightDealsEnabled() === true) {
        showResultInlineMulti()
    }
    if (window.R9Admin) {
        setTimeout(updateDOMInfo, 3000)
    }
    jq(window).trigger("finalUpdateDisplayDone")
}

function updateDOMInfo() {
    var a = new Date().getTime();
    jq("#dominfo .count").html([jq("*").length, " (", new Date().getTime() - a, " ms)."].join(""))
}

function getResultID(a) {
    return R9.RP.getResultId(a)
}

function getResultName(a) {
    return jq("#tbd" + a).data("hname") || jq("#hname" + a).html()
}

function removeDisplay(a) {
    ViewState.update("removed", a)
}

function clone(a) {
    return jq.extend({}, a)
}

function samelist(c, a) {
    if (c == null || a == null) {
        return c == a
    }
    if (c.length != a.length) {
        return false
    }
    for (var b = 0; b < c.length; b++) {
        if (c[b] != a[b]) {
            return false
        }
    }
    return true
}(function(a) {
    R9.extend("RP", {
        getResultId: function(b) {
            var c = a("#tbd" + b).data("resultid") || a("#resultid" + b).text() || a("[idx=" + b + "]").data("resultid");
            if (c) {
                return a.trim(c.toString())
            }
            return null
        },
        isHotel: function() {
            return R9.globals != null && R9.globals.vertical == "hotel"
        }
    })
})(jq || jQuery);
(function(a) {
    R9.extend("RP", {
        InlineForm: function(d, b) {
            this.form = a(d);
            this.e = this.form.get(0);
            this.options.cmp2Enabled = window.inlineFormCmp2Enabled;
            this.options = a.extend(true, {}, this.options, b || {});
            var c = this;
            this.localHistory = new R9.Common.UserHistory({
                onSave: function() {
                    c.updateLocalHistory()
                }
            });
            this.bindEvents()
        }
    });
    R9.extend("RP.InlineForm", {
        submit: function(d, c) {
            var b = new R9.RP.InlineForm(d, c);
            return b.submit()
        }
    });
    R9.extend("RP.InlineForm.prototype", {
        form: null,
        options: {
            adtString: "inlinesearch/searchagain",
            message: "",
            cmp2Enabled: false,
            cmp2FieldSelector: "input[name='comparetosite']",
            isHotelSearch: false,
            isFlightSearch: false
        },
        bindSubmit: function() {
            var b = this;
            if (typeof R9.globals.submitTimeout != "undefined" && R9.globals.submitTimeout > 0 && window.location.hash.length == 0) {
                jq(this.e).submit(function(c) {
                    c.preventDefault();
                    setTimeout(function() {
                        b.submit.call(b)
                    }, R9.globals.submitTimeout)
                })
            } else {
                jq(this.e).submit(jq.proxy(this.submit, this))
            }
        },
        bindCmp2Events: function() {
            var b = new R9.CompareTo.Controller(R9.CompareTo.View.getViewFromForm(this.e), new R9.CompareTo.Model());
            b.setShowOnResult()
        },
        bindEvents: function() {
            this.bindSubmit();
            this.bindCmp2Events()
        },
        serializeSearchProps: function(c) {
            var d = this.e,
                b = {};
            c.forEach(function(g) {
                try {
                    b[g] = jq(d[g]).val()
                } catch (f) {}
            });
            return b
        },
        saveCarSearch: function() {
            var c = ["pickup_hour", "dropoff_hour", "provider", "location", "location2", "citycode", "citycode2"];
            var b = this.serializeSearchProps(c);
            this.localHistory.pushSearchHistory(b)
        },
        saveFlightsSearch: function() {
            var d = this.e,
                c = ["oneway", "fid", "cabin", "nearbyO", "nearbyD", "destcode", "prefer_nonstop", "origin", "destination", "origincode"];
            if (d === undefined) {
                return
            }
            if (d.dtFlexCat) {
                c = c.concat(["dtFlexCat", "depart_time", "depart_date_flex", "return_time", "lengthofstay", "return_date_flex", "weekend_depart_date", "weekend_depart", "weekend_return"])
            }
            var b = this.serializeSearchProps(c);
            jq(".fieldInputPTCType .numberHolder").each(function(f) {
                var h = jq(this).val();
                var g = jq(this).parent().parent().data("for").toLowerCase();
                if (!isNaN(h)) {
                    b[g] = h
                }
            });
            this.localHistory.pushSearchHistory(b)
        },
        saveHotelSearch: function() {
            var c = this.e,
                b = this.serializeSearchProps(["othercity", "citycode", "hid", "lmid", "searchType"]);
            b.rooms = "rooms-input" in c ? c["rooms-input"].value : c.rooms.value;
            b.guests = "guests-input" in c ? c["guests-input"].value : c["guests" + c.rooms.value].value;
            this.localHistory.pushSearchHistory(b)
        },
        updateLocalHistory: function(b) {
            switch (this.localHistory.pageTab) {
                case "cars":
                    this.saveCarSearch();
                    break;
                case "hotels":
                    this.saveHotelSearch();
                    break;
                case "flights":
                    this.saveFlightsSearch();
                    break;
                case "packagetours":
                    break;
                default:
                    break
            }
        },
        isValid: function() {
            var c = this.e.checkin_date.value;
            var d = this.e.checkout_date.value;
            var b = null;
            if (c.length == 0) {
                b = "Please enter a check-in date."
            } else {
                if (d.length == 0) {
                    b = "Please enter a check-out date."
                }
            }
            return b
        },
        isValidFlightSearch: function() {
            if (this.e.dtFlexCat.value != "exact" && this.e.dtFlexCat.value != "plusminusthree") {
                return null
            }
            var b = this.e.depart_date.value;
            var d = this.e.return_date.value;
            var c = null;
            if (b.length == 0) {
                c = "Please enter a valid departure date."
            } else {
                if (this.e.oneway.value == "n" && d.length == 0) {
                    c = "Please enter a valid return date."
                }
            }
            return c
        },
        submit: function() {
            try {
                if (this.options.isHotelSearch) {
                    var c = this.isValid();
                    if (c) {
                        alert(c);
                        return false
                    }
                } else {
                    if (this.options.isFlightSearch) {
                        var c = this.isValidFlightSearch();
                        if (c) {
                            alert(c);
                            return false
                        }
                    }
                }
                this.updateLocalHistory(true);
                if (R9.RP.isHotel()) {
                    R9.Common.Model.HotelList().clear()
                }
                R9.Analytics.api.trackEvent(this.options.adtString);
                a("body").css("cursor", "wait");
                var b = R9.URL.Generator.generate(this.form, {
                    isInlineSearch: true
                });
                if (b != null) {
                    if (R9.RP.ResultsExpired != null) {
                        R9.RP.ResultsExpired.cancel()
                    }
                    jq("button", this.form).each(function() {
                        var f = a(this);
                        if (f.attr("type") == "submit") {
                            f.prop("disabled", true)
                        }
                    });
                    jq.cookie("nus", "t", {
                        path: "/"
                    });
                    this.navigateToResults(b);
                    return false
                }
            } catch (d) {
                R9.utils.log("Exception " + d + " in R9.RP.InlineForm.prototype.submit(). Abort", d);
                return false
            }
            return true
        },
        inlineSearchValidateCmp2: function() {
            var c = this.form.find(this.options.cmp2FieldSelector);
            var b = c.length;
            if (!b) {
                return
            }
            var d = 0;
            c.each(function(f) {
                d++
            });
            R9.Analytics.api.trackEvent("inlinesearch/cmp2/" + d + "/" + b)
        },
        navigateToResults: function(b) {
            jq("button", this.form).each(function() {
                var c = jq(this);
                if (c.attr("type") == "submit") {
                    c.prop("disabled", false)
                }
            });
            R9App.AppInstance.navigate(b, {
                reload: true
            })
        }
    })
})(jq || jQuery);

function Streamer(c, a, f, d) {
    var b = {
        error: null,
        done: c,
        lastPoll: a,
        url: "/s/jsresults?searchid=" + SearchID,
        maxPolls: 200,
        delay: 250,
        pollCount: 0,
        pollCount2: 0,
        idleCount: 0,
        request: null,
        searchid: d,
        startTime: new Date().getTime(),
        poll: function() {
            this.pollTimer = null;
            this.pollCount++;
            this.dbg("Poll #" + this.pollCount + " >");
            this.doPoll(this.pollCount, this.done, this.lastPoll)
        },
        doPoll: function(j, g, h) {
            if (window.ssRefreshResults) {
                this.request = ssRefreshResults(j, g, h)
            } else {
                this.request = jq.getScript(this.url + "&final=" + g + "&updateStamp=" + h + "&poll=" + j)
            }
        },
        reset: function() {
            if (this.stillPolling()) {
                this.hardStop()
            }
            this.done = false;
            this.pollCount = this.pollCount2 = this.idleCount = 0
        },
        stack: function(h, j) {
            var g = h && h.stack || window.printStackTrace && printStackTrace({
                e: h
            }).join("\n\n") || "unavailable";
            this.dbg((j || "Error stack:") + "\n\n" + g);
            return g
        },
        err: function(j, h, k) {
            var k = k || "";
            var g = ((j && j.name) ? j.name : "ERROR") + ": " + ((j && j.message) ? j.message : "UNKNOWN ERROR");
            this.dbg("!!! " + g + (k.length > 0 ? " while evaling: <pre>" + jq("<div/>").text(k).html() + "</pre>" : ""));
            this.error = j;
            this.stopTwoPhase();
            this.stack(j);
            if (!window.location.href.match("streamerr=")) {
                this.clienttimeout("streamerr=" + g.replace(/\s+/g, "+"))
            } else {
                alert("FATAL error has occured: " + g)
            }
            throw j
        },
        whenDone: function(h) {
            var g = function() {
                h.apply(window.Streaming, Array.prototype.slice.call(arguments, 1))
            };
            if (this.done) {
                g()
            } else {
                jq(window).bind("r9.streaming.done", g)
            }
        },
        finalResults: function(g) {
            if (!this.done) {
                jq(window).trigger("r9.streaming.done")
            }
            this.done = true;
            if (g) {
                this.secondPhase = true
            }
        },
        nextPoll: function(j, k) {
            var h = this;
            if (!this.done && this.pollCount >= this.maxPolls) {
                this.dbg("Too many polls, and still not done: " + this.pollCount + ">=" + this.maxPolls + ". ABORTING.");
                return this.clienttimeout("streamerr=" + this.pollCount + "+too+many+polls")
            }
            if (k) {
                this.dbg(k)
            }
            if (!this.done) {
                var g = Math.ceil(this.delay * (1 + Math.floor(this.pollCount / 20) * 0.5));
                this.pollTimer = window.setTimeout(function() {
                    h.poll()
                }, g);
                this.dbg("Nxt in " + g + ": " + this.pollTimer);
                return true
            } else {
                if (j || this.secondPhase) {
                    return this.pollSecondPhase()
                } else {
                    if (!this.stoppedPolling) {
                        this.dbg("POLL DONE.");
                        this.stoppedPolling = true
                    }
                }
            }
            return false
        },
        pollSecondPhase: function() {
            if (!window.SecondPhaseWait) {
                this.dbg("No 2F.");
                return false
            }
            if (this.pollCount2 < 0) {
                Streaming.dbg("2F ABORTED.");
                return false
            }
            this.dbg("2F in " + window.SecondPhaseWait);
            var g = this;
            if (this.pollCount2 == 0) {
                this.scndPhaseTimeouts = {
                    ids: [window.setTimeout(function() {
                        g.enoughresults()
                    }, SecondPhaseTimeout - 5000), window.setTimeout(function() {
                        g.stopTwoPhase()
                    }, SecondPhaseTimeout)],
                    clear: function() {
                        if (this.ids) {
                            for (i in this.ids) {
                                clearTimeout(this.ids[i])
                            }
                        }
                        this.ids = null
                    }
                }
            }
            this.pollCount2++;
            window.setTimeout(function() {
                g.checkSecondPhase()
            }, window.SecondPhaseWait);
            return true
        },
        stillPolling: function() {
            return !this.done || this.pollCount2 > 0
        },
        checkSecondPhase: function() {
            if (window.SearchType == "hotel") {
                _ALLRESULTSLOADED = false
            }
            this.dbg("2F #" + this.pollCount2 + " >");
            this.request = jq.getScript("/s/run/search/spdone?searchid=" + SearchID + "&poll=" + this.pollCount2)
        },
        stopTwoPhase: function(g) {
            this.dbg("2F STOP.");
            this.pollCount2 = -1;
            this.secondPhase = false;
            this.secondPhaseAvailable = true;
            g = jq.trim(g);
            if (g) {
                jq("#aboveresultsmessagetd").html(g).show()
            } else {
                jq("#aboveresultsmessagetd").hide()
            }
            if (this.scndPhaseTimeouts) {
                this.scndPhaseTimeouts.clear()
            }
        },
        doneSecondPhase: function(g) {
            this.dbg("2F done.");
            this.stopTwoPhase(g);
            if (window.secondPhaseDone) {
                window.secondPhaseDone()
            }
        },
        showAllResults: function(g) {
            if (window.matrixClearSelected) {
                matrixClearSelected()
            }
            if (this.secondPhaseAvailable) {
                R9.Analytics.api.trackEvent("2phase/addAllClicked");
                window.location.replace(window.location.href + "&showall=true")
            } else {
                FilterList.resetFilters()
            }
        },
        start: function(g) {
            this.delay = g;
            this.poll()
        },
        beginResponse: function(g, h) {
            g = g || this.pollCount;
            var j = this.stillPolling() ? "Poll #" + g : "Update ...";
            this.dbg("Poll #" + g + " <: " + (h || "-"))
        },
        _dbglines: [],
        dbg: function(h) {
            if (h == null) {
                this._dbglines = [];
                return
            }
            var g = new Date().getTime() - this.startTime;
            this._dbglines.push("" + g + ": " + h)
        },
        getdbg: function() {
            return this._dbglines ? this._dbglines.join("|") : ""
        },
        checkpoint: function(g) {
            this.dbg("Checkpoint: " + g)
        },
        dbg2: function(g) {
            this.dbg(g)
        },
        enoughresults: function() {
            jq.get("/s/sparkle?action=killseeker&searchid=" + SearchID + "&formtoken=" + R9.globals.formtoken);
            try {
                jq("#enoughtbuttonspan").hide();
                jq("#enoughtbuttonspanoff").innerHTML = "Loading search results..."
            } catch (g) {}
        },
        hardStop: function() {
            this.dbg("HSTP: DONE.");
            if (this.request) {
                this.request.abort()
            }
            clearTimeout(this.pollTimer);
            this.done = true;
            this.secondp = true
        },
        clienttimeout: function(g) {
            if (this.done) {
                this.dbg("TMT: DONE.");
                return
            }
            this.enoughresults();
            this.done = true;
            this.dbg("TMT: ABORT.");
            var h = this;
            window.setTimeout(function() {
                h.dbg("TMT: reloading");
                if (window.R9Admin) {
                    var m = h.error == null ? "Timeout" : h.error.name + ":" + h.error.message;
                    if (h.error && h.error.name == "STLDPRG") {
                        m = "Stalled progress."
                    }
                    if (!confirm("Forcing reload because of " + m + ". This message is only visible to admin.")) {
                        return false
                    }
                }
                if (window.Filters && window.Filters.saveState) {
                    Filters.saveState()
                }
                if (document.location.hash) {
                    var k = document.location.hash.indexOf("/") == 1 ? document.location.hash.substring(2) : document.location.hash.substring(1);
                    var l = document.location.pathname + "/" + k + "?force=remaining&clienttimeout=true" + (g ? "&" + g : "");
                    var j = l.replace(/\/\//g, "/");
                    R9App.AppInstance.navigate(j)
                } else {
                    if (window.location.href.indexOf("?force", 0)) {
                        R9.UILogger.logTimeout("streaming", "Front End Timeout", function() {
                            h.redirect(g)
                        })
                    } else {
                        h.redirect(g)
                    }
                }
            }, 500);
            return false
        },
        redirect: function(g) {
            if (window.location.href.indexOf("?force", 0) == -1) {
                window.location.replace(window.location.href + "?force=remaining&clienttimeout=true" + (g ? "&" + g : ""))
            } else {
                window.location.reload()
            }
        },
        startClientTimeout: function(j) {
            if (j && !this.done) {
                j = j + 5000;
                var h = this.searchid;
                var g = this;
                R9.globals.streamingTimer = window.setTimeout(function() {
                    if (h == window.searchid) {
                        g.clienttimeout("streamerr=" + j + "+timeout+expired")
                    }
                }, j)
            }
        },
        stopClientTimeout: function() {
            if (R9.globals && R9.globals.streamingTimer) {
                window.clearTimeout(R9.globals.streamingTimer);
                R9.globals.streamingTimer = null
            }
        }
    };
    b.stopClientTimeout();
    b.startClientTimeout(f);
    b._created = new Date();
    b.dbg("CRT");
    return b
}
window.R9App = window.R9App || {};
window.R9App.scripts = window.R9App.scripts || {};
window.R9App.scripts["/js/streaming.js"] = true;
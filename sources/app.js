'use strict';

const {
    Button,
    Card,
    Col,
    ControlGroup,
    Drawer,
    FocusManager,
    Grid,
    Icon,
    ResponsiveManager,
    Select,
    Switch,

} = CUI;

/*
 * Blurgh.
 */
const faq = [
    {
        q: 'What is this?',
        a: `A collection of freely available workouts from various places on
        the Internet, refreshed daily.`
    },
    {
        q: 'How do I use it?',
        a: `Create your own list of workouts by choosing a source and clicking
        the plus button. Revisit tomorrow for new workouts.`
    },
    {
        q: 'Who owns the content?',
        a: `All content is owned by the provider; I just aggregate it for you.`
    },
    {
        q: 'Is the source code available?',
        a: 'Sure, on <a href="https://github.com/angrytongan/wodscrape">Github</a>.'
    },
    {
        q: 'Other stuff',
        a: `Generated %build-date%<br />
            Comments? <a href="https://reddit.com/u/angrytongan">Contact me</a>`
    },
];

const AppModel = () => {
    let options = {
        darkMode: false,
    };

    const saveOptions = () => {
        localStorage.setItem('options', JSON.stringify(options));
    };

    const setMode = () => {
        document.documentElement.setAttribute('data-theme', options.darkMode ? 'dark' : 'light');
    };

    return {
        init: () => {
            let o = localStorage.getItem('options');
            if (o === null) {
                saveOptions();
            } else {
                options = JSON.parse(o);
            }

            setMode();
        },

        mode: () => options.darkMode,
        toggleMode: () => {
            options.darkMode = !options.darkMode;
            saveOptions();
            setMode();
        }
    };
};
const appModel = AppModel();

/*
 */
const SourcesModel = () => {
    const cookieName = 'wods';
    const sources = [
        %sources%
    ];

    return {
        sources: () => sources,
    };
};
const sourcesModel = SourcesModel();
const ResultsModel = () => {
    let results = [];
    const cookieName = 'wods';

    const remember = () => {
        let s = results.reduce((out, r) => {
            return out += r.source + ',';
        }, '');

        s = s.replace(/,$/, '');

        Cookies.remove(cookieName);
        if (s !== '') {
            Cookies.set(cookieName, s, { expires: 365 });
        }
    };

    const recall = () => {
        let cookie = Cookies.get(cookieName);

        return cookie ? cookie.split(',') : [];
    };

    const fetchSource = (source) => {
        const url = '/' + source.replace(/ /g, '-') + '.html';
        m.request({
            method: 'GET',
            url: url,
            responseType: 'text',
            headers: {
                Accept: 'text/html',
            },
        })
        .then((r) => {
            results.unshift({ source: source, result: r });
            remember();
        })
        .catch((err) => {
            console.error(err);
        });
    };

    return {
        fetchResult: (source) => {
            fetchSource(source);
        },

        getResults: () => results,

        removeResult: (i) => {
            results.splice(i, 1);
            remember();
        },

        fetchFromCookie: () => {
            let sources = recall().slice(0).reverse();
            sources.map((s) => {
                fetchSource(s);
            });
        },
    };
};
const resultsModel = ResultsModel();
const Results = {
    oninit: () => {
    },

    view: () => {
        return m(Grid, resultsModel.getResults().map((r, i) => {
            return m(Col, {
                span: { xs: 12, sm: 6, lg: 4 },
            }, m(Card, {
                class: 'workout',
                fluid: true,
            }, [
                m(Icon, {
                    name: 'x',
                    intent: 'negative',
                    onclick: (e) => { resultsModel.removeResult(i); },
                }), m.trust(r.result)
            ]));
        }));
    },
};

const Controls = () => {
    let source = '';
    let isOpen = false;

    return {
        oninit: () => {
            source = sourcesModel.sources()[0];
            resultsModel.fetchFromCookie();
        },
        view: () => {
            return m('', [
                m('#drawer', [
                    m(Drawer, {
                        addToStack: true,
                        closeOnEscapeKey: true,
                        closeOnOutsideClick: true,
                        hasBackdrop: true,
                        inline: false,
                        isOpen: isOpen,
                        position: 'right',
                        content: [
                            m(Icon, {
                                name: 'x',
                                intent: 'negative',
                                onclick: (e) => { isOpen = false; },
                            }),
                            m('dl', faq.map((e) => {
                                return [ m('dt', e.q), m('dd', m.trust(e.a)) ];
                            })),
                        ],
                        onClose: () => { isOpen = false; },
                    }),
                ]),
                m(ControlGroup, [
                    m(Select, {
                        fluid: true,
                        options: sourcesModel.sources(),
                        value: source,
                        onchange: (e) => {
                            source = e.currentTarget.value;
                        },
                    }),
                    m(Button, {
                        iconLeft: 'plus',
                        intent: 'default',
                        onclick: (e) => { resultsModel.fetchResult(source) },
                    }),
                    m(Button, {
                        iconLeft: 'info',
                        intent: 'default',
                        onclick: (e) => { isOpen = !isOpen },
                    }),
                    m(Switch, {
                        label: 'Dark mode',
                        checked: appModel.mode(),
                        onchange: () => { appModel.toggleMode(); },
                    }),
                ]),
            ]);
        },
    };
};

const Main = {
    oninit: () => {
        appModel.init();
    },

    view: () => {
        return m(Grid, [
            m(Col, { span: 12 }, m(Controls)),
            m(Col, { span: 12 }, m(Results)),
        ]);
    },
};

document.addEventListener('DOMContentLoaded', () => {
    const root = document.body;

    FocusManager.showFocusOnlyOnTab();
    ResponsiveManager.initialize();

    m.route(root, '/', {
        '/': Main,
    });
});

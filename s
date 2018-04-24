[1mdiff --git a/data-handlers/EnCours.txt b/data-handlers/EnCours.txt[m
[1mindex 005f047..1bfc37b 100644[m
[1m--- a/data-handlers/EnCours.txt[m
[1m+++ b/data-handlers/EnCours.txt[m
[36m@@ -17,12 +17,13 @@[m [mvoir pour mutualiser tout le code de la timeline et uniquement celui dans un seu[m
 [m
 3. Nouveaux développements[m
 Ajout de la possibilité d'avoir plusieurs timelines (avec les groupes de jis.js)[m
[31m-Ajout d'une mind map dans laquelle on peut afficher les éléments de la timeline[m
[31m-Double cliquer (ou menu contextuel!) sur un élément pour avoir accès à une sous-timeline[m
[31m-exporter les informations dans un tableur[m
[32m+[m[32mAjout d'une mind map dans laquelle on peut afficher les éléments de la timeline pour pouvoir les lier entre eux de différentes manières (liens de causalités, d'appartenance, ...)[m
[32m+[m[32mMenu contextuel sur un élément pour avoir accès à une sous-timeline[m
[32m+[m[32mexporter les informations dans un tableur, un rapport[m
 éditeur de texte pour la prise de notes (https://quilljs.com/  http://bootstrap-wysiwyg.github.io/bootstrap3-wysiwyg/  )[m
 styliser front-side les items de la timeline[m
 Persistance des options et modification front-side[m
[32m+[m[32mBouton pour focus sur la time line, un autre pour focus sur un item[m
 [m
 4. Environnement de développement[m
 	ajout des logs[m
[1mdiff --git a/data-handlers/assets/js.js b/data-handlers/assets/js.js[m
[1mindex 0c0e7a6..aca5f3b 100644[m
[1m--- a/data-handlers/assets/js.js[m
[1m+++ b/data-handlers/assets/js.js[m
[36m@@ -9,6 +9,10 @@[m [mvar $ = require('jquery');[m
 [m
 require('popper.js');[m
 require('bootstrap');[m
[32m+[m
[32m+[m[32m//require('quill');[m[41m [m
[32m+[m[32m//require('../node_modules/quill/dist/quill.js');[m[41m [m
[32m+[m[32m//[m
 //require('vis');[m
 //var vis = require('vis');[m
 //var $ = require('vis');[m
[1mdiff --git a/data-handlers/package-lock.json b/data-handlers/package-lock.json[m
[1mnew file mode 100644[m
[1mindex 0000000..246d0a7[m
[1m--- /dev/null[m
[1m+++ b/data-handlers/package-lock.json[m
[36m@@ -0,0 +1,3914 @@[m
[32m+[m[32m{[m
[32m+[m[32m    "requires": true,[m
[32m+[m[32m    "lockfileVersion": 1,[m
[32m+[m[32m    "dependencies": {[m
[32m+[m[32m        "clone": {[m
[32m+[m[32m            "version": "2.1.2",[m
[32m+[m[32m            "resolved": "https://registry.npmjs.org/clone/-/clone-2.1.2.tgz",[m
[32m+[m[32m            "integrity": "sha1-G39Ln1kfHo+DZwQBYANFoCiHQ18="[m
[32m+[m[32m        },[m
[32m+[m[32m        "deep-equal": {[m
[32m+[m[32m            "version": "1.0.1",[m
[32m+[m[32m            "resolved": "https://registry.npmjs.org/deep-equal/-/deep-equal-1.0.1.tgz",[m
[32m+[m[32m            "integrity": "sha1-9dJgKStmDghO/0zbyfCK0yR0SLU="[m
[32m+[m[32m        },[m
[32m+[m[32m        "eventemitter3": {[m
[32m+[m[32m            "version": "2.0.3",[m
[32m+[m[32m            "resolved": "https://registry.npmjs.org/eventemitter3/-/eventemitter3-2.0.3.tgz",[m
[32m+[m[32m            "integrity": "sha1-teEHm1n7XhuidxwKmTvgYKWMmbo="[m
[32m+[m[32m        },[m
[32m+[m[32m        "extend": {[m
[32m+[m[32m            "version": "3.0.1",[m
[32m+[m[32m            "resolved": "https://registry.npmjs.org/extend/-/extend-3.0.1.tgz",[m
[32m+[m[32m            "integrity": "sha1-p1Xqe8Gt/MWjHOfnYtuq3F5jZEQ="[m
[32m+[m[32m        },[m
[32m+[m[32m        "fast-diff": {[m
[32m+[m[32m            "version": "1.1.2",[m
[32m+[m[32m            "resolved": "https://registry.npmjs.org/fast-diff/-/fast-diff-1.1.2.tgz",[m
[32m+[m[32m            "integrity": "sha512-KaJUt+M9t1qaIteSvjc6P3RbMdXsNhK61GRftR6SNxqmhthcd9MGIi4T+o0jD8LUSpSnSKXE20nLtJ3fOHxQig=="[m
[32m+[m[32m        },[m
[32m+[m[32m        "npm": {[m
[32m+[m[32m            "version": "5.8.0",[m
[32m+[m[32m            "resolved": "https://registry.npmjs.org/npm/-/npm-5.8.0.tgz",[m
[32m+[m[32m            "integrity": "sha512-DowXzQwtSWDtbAjuWecuEiismR0VdNEYaL3VxNTYTdW6AGkYxfGk9LUZ/rt6etEyiH4IEk95HkJeGfXE5Rz9xQ==",[m
[32m+[m[32m            "requires": {[m
[32m+[m[32m                "JSONStream": "1.3.2",[m
[32m+[m[32m                "abbrev": "1.1.1",[m
[32m+[m[32m                "ansi-regex": "3.0.0",[m
[32m+[m[32m                "ansicolors": "0.3.2",[m
[32m+[m[32m                "ansistyles": "0.1.3",[m
[32m+[m[32m                "aproba": "1.2.0",[m
[32m+[m[32m                "archy": "1.0.0",[m
[32m+[m[32m                "bin-links": "1.1.0",[m
[32m+[m[32m                "bluebird": "3.5.1",[m
[32m+[m[32m                "cacache": "10.0.4",[m
[32m+[m[32m                "call-limit": "1.1.0",[m
[32m+[m[32m                "chownr": "1.0.1",[m
[32m+[m[32m                "cli-table2": "0.2.0",[m
[32m+[m[32m                "cmd-shim": "2.0.2",[m
[32m+[m[32m                "columnify": "1.5.4",[m
[32m+[m[32m                "config-chain": "1.1.11",[m
[32m+[m[32m                "debuglog": "1.0.1",[m
[32m+[m[32m                "detect-indent": "5.0.0",[m
[32m+[m[32m                "detect-newline": "2.1.0",[m
[32m+[m[32m                "dezalgo": "1.0.3",[m
[32m+[m[32m                "editor": "1.0.0",[m
[32m+[m[32m                "find-npm-prefix": "1.0.2",[m
[32m+[m[32m                "fs-vacuum": "1.2.10",[m
[32m+[m[32m                "fs-write-stream-atomic": "1.0.10",[m
[32m+[m[32m                "gentle-fs": "2.0.1",[m
[32m+[m[32m                "glob": "7.1.2",[m
[32m+[m[32m                "graceful-fs": "4.1.11",[m
[32m+[m[32m                "has-unicode": "2.0.1",[m
[32m+[m[32m                "hosted-git-info": "2.6.0",[m
[32m+[m[32m                "iferr": "0.1.5",[m
[32m+[m[32m                "imurmurhash": "0.1.4",[m
[32m+[m[32m                "inflight": "1.0.6",[m
[32m+[m[32m                "inherits": "2.0.3",[m
[32m+[m[32m                "ini": "1.3.5",[m
[32m+[m[32m                "init-package-json": "1.10.3",[m
[32m+[m[32m                "is-cidr": "1.0.0",[m
[32m+[m[32m                "json-parse-better-errors": "1.0.1",[m
[32m+[m[32m                "lazy-property": "1.0.0",[m
[32m+[m[32m                "libcipm": "1.6.0",[m
[32m+[m[32m                "libnpx": "10.0.1",[m
[32m+[m[32m                "lockfile": "1.0.3",[m
[32m+[m[32m                "lodash._baseindexof": "3.1.0",[m
[32m+[m[32m                "lodash._baseuniq": "4.6.0",[m
[32m+[m[32m                "lodash._bindcallback": "3.0.1",[m
[32m+[m[32m                "lodash._cacheindexof": "3.0.2",[m
[32m+[m[32m                "lodash._createcache": "3.1.2",[m
[32m+[m[32m                "lodash._getnative": "3.9.1",[m
[32m+[m[32m                "lodash.clonedeep": "4.5.0",[m
[32m+[m[32m                "lodash.restparam": "3.6.1",[m
[32m+[m[32m                "lodash.union": "4.6.0",[m
[32m+[m[32m                "lodash.uniq": "4.5.0",[m
[32m+[m[32m                "lodash.without": "4.4.0",[m
[32m+[m[32m                "lru-cache": "4.1.1",[m
[32m+[m[32m                "meant": "1.0.1",[m
[32m+[m[32m                "mississippi": "3.0.0",[m
[32m+[m[32m                "mkdirp": "0.5.1",[m
[32m+[m[32m                "move-concurrently": "1.0.1",[m
[32m+[m[32m                "nopt": "4.0.1",[m
[32m+[m[32m                "normalize-package-data": "2.4.0",[m
[32m+[m[32m                "npm-cache-filename": "1.0.2",[m
[32m+[m[32m                "npm-install-checks": "3.0.0",[m
[32m+[m[32m                "npm-lifecycle": "2.0.1",[m
[32m+[m[32m                "npm-package-arg": "6.0.0",[m
[32m+[m[32m                "npm-packlist": "1.1.10",[m
[32m+[m[32m                "npm-profile": "3.0.1",[m
[32m+[m[32m                "npm-registry-client": "8.5.1",[m
[32m+[m[32m                "npm-user-validate": "1.0.0",[m
[32m+[m[32m                "npmlog": "4.1.2",[m
[32m+[m[32m                "once": "1.4.0",[m
[32m+[m[32m                "opener": "1.4.3",[m
[32m+[m[32m                "osenv": "0.1.5",[m
[32m+[m[32m                "pacote": "7.6.1",[m
[32m+[m[32m                "path-is-inside": "1.0.2",[m
[32m+[m[32m                "promise-inflight": "1.0.1",[m
[32m+[m[32m                "qrcode-terminal": "0.11.0",[m
[32m+[m[32m                "query-string": "5.1.0",[m
[32m+[m[32m                "qw": "1.0.1",[m
[32m+[m[32m                "read": "1.0.7",[m
[32m+[m[32m                "read-cmd-shim": "1.0.1",[m
[32m+[m[32m                "read-installed": "4.0.3",[m
[32m+[m[32m                "read-package-json": "2.0.13",[m
[32m+[m[32m                "read-package-tree": "5.1.6",[m
[32m+[m[32m                "readable-stream": "2.3.5",[m
[32m+[m[32m                "readdir-scoped-modules": "1.0.2",[m
[32m+[m[32m                "request": "2.83.0",[m
[32m+[m[32m                "retry": "0.10.1",[m
[32m+[m[32m                "rimraf": "2.6.2",[m
[32m+[m[32m                "safe-buffer": "5.1.1",[m
[32m+[m[32m                "semver": "5.5.0",[m
[32m+[m[32m                "sha": "2.0.1",[m
[32m+[m[32m                "slide": "1.1.6",[m
[32m+[m[32m                "sorted-object": "2.0.1",[m
[32m+[m[32m                "sorted-union-stream": "2.1.3",[m
[32m+[m[32m                "ssri": "5.2.4",[m
[32m+[m[32m                "strip-ansi": "4.0.0",[m
[32m+[m[32m                "tar": "4.4.0",[m
[32m+[m[32m                "text-table": "0.2.0",[m
[32m+[m[32m                "uid-number": "0.0.6",[m
[32m+[m[32m                "umask": "1.1.0",[m
[32m+[m[32m                "unique-filename": "1.1.0",[m
[32m+[m[32m                "unpipe": "1.0.0",[m
[32m+[m[32m                "update-notifier": "2.3.0",[m
[32m+[m[32m                "uuid": "3.2.1",[m
[32m+[m[32m                "validate-npm-package-license": "3.0.1",[m
[32m+[m[32m                "validate-npm-package-name": "3.0.0",[m
[32m+[m[32m                "which": "1.3.0",[m
[32m+[m[32m                "worker-farm": "1.5.4",[m
[32m+[m[32m                "wrappy": "1.0.2",[m
[32m+[m[32m                "write-file-atomic": "2.3.0"[m
[32m+[m[32m            },[m
[32m+[m[32m            "dependencies": {[m
[32m+[m[32m                "JSONStream": {[m
[32m+[m[32m                    "version": "1.3.2",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "jsonparse": "1.3.1",[m
[32m+[m[32m                        "through": "2.3.8"[m
[32m+[m[32m                    },[m
[32m+[m[32m                    "dependencies": {[m
[32m+[m[32m                        "jsonparse": {[m
[32m+[m[32m                            "version": "1.3.1",[m
[32m+[m[32m                            "bundled": true[m
[32m+[m[32m                        },[m
[32m+[m[32m                        "through": {[m
[32m+[m[32m                            "version": "2.3.8",[m
[32m+[m[32m                            "bundled": true[m
[32m+[m[32m                        }[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "abbrev": {[m
[32m+[m[32m                    "version": "1.1.1",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "ansi-regex": {[m
[32m+[m[32m                    "version": "3.0.0",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "ansicolors": {[m
[32m+[m[32m                    "version": "0.3.2",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "ansistyles": {[m
[32m+[m[32m                    "version": "0.1.3",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "aproba": {[m
[32m+[m[32m                    "version": "1.2.0",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "archy": {[m
[32m+[m[32m                    "version": "1.0.0",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "bin-links": {[m
[32m+[m[32m                    "version": "1.1.0",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "bluebird": "3.5.1",[m
[32m+[m[32m                        "cmd-shim": "2.0.2",[m
[32m+[m[32m                        "fs-write-stream-atomic": "1.0.10",[m
[32m+[m[32m                        "gentle-fs": "2.0.1",[m
[32m+[m[32m                        "graceful-fs": "4.1.11",[m
[32m+[m[32m                        "slide": "1.1.6"[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "bluebird": {[m
[32m+[m[32m                    "version": "3.5.1",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "cacache": {[m
[32m+[m[32m                    "version": "10.0.4",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "bluebird": "3.5.1",[m
[32m+[m[32m                        "chownr": "1.0.1",[m
[32m+[m[32m                        "glob": "7.1.2",[m
[32m+[m[32m                        "graceful-fs": "4.1.11",[m
[32m+[m[32m                        "lru-cache": "4.1.1",[m
[32m+[m[32m                        "mississippi": "2.0.0",[m
[32m+[m[32m                        "mkdirp": "0.5.1",[m
[32m+[m[32m                        "move-concurrently": "1.0.1",[m
[32m+[m[32m                        "promise-inflight": "1.0.1",[m
[32m+[m[32m                        "rimraf": "2.6.2",[m
[32m+[m[32m                        "ssri": "5.2.4",[m
[32m+[m[32m                        "unique-filename": "1.1.0",[m
[32m+[m[32m                        "y18n": "4.0.0"[m
[32m+[m[32m                    },[m
[32m+[m[32m                    "dependencies": {[m
[32m+[m[32m                        "mississippi": {[m
[32m+[m[32m                            "version": "2.0.0",[m
[32m+[m[32m                            "bundled": true,[m
[32m+[m[32m                            "requires": {[m
[32m+[m[32m                                "concat-stream": "1.6.1",[m
[32m+[m[32m                                "duplexify": "3.5.4",[m
[32m+[m[32m                                "end-of-stream": "1.4.1",[m
[32m+[m[32m                                "flush-write-stream": "1.0.2",[m
[32m+[m[32m                                "from2": "2.3.0",[m
[32m+[m[32m                                "parallel-transform": "1.1.0",[m
[32m+[m[32m                                "pump": "2.0.1",[m
[32m+[m[32m                                "pumpify": "1.4.0",[m
[32m+[m[32m                                "stream-each": "1.2.2",[m
[32m+[m[32m                                "through2": "2.0.3"[m
[32m+[m[32m                            },[m
[32m+[m[32m                            "dependencies": {[m
[32m+[m[32m                                "concat-stream": {[m
[32m+[m[32m                                    "version": "1.6.1",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "inherits": "2.0.3",[m
[32m+[m[32m                                        "readable-stream": "2.3.5",[m
[32m+[m[32m                                        "typedarray": "0.0.6"[m
[32m+[m[32m                                    },[m
[32m+[m[32m                                    "dependencies": {[m
[32m+[m[32m                                        "typedarray": {[m
[32m+[m[32m                                            "version": "0.0.6",[m
[32m+[m[32m                                            "bundled": true[m
[32m+[m[32m                                        }[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                },[m
[32m+[m[32m                                "duplexify": {[m
[32m+[m[32m                                    "version": "3.5.4",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "end-of-stream": "1.4.1",[m
[32m+[m[32m                                        "inherits": "2.0.3",[m
[32m+[m[32m                                        "readable-stream": "2.3.5",[m
[32m+[m[32m                                        "stream-shift": "1.0.0"[m
[32m+[m[32m                                    },[m
[32m+[m[32m                                    "dependencies": {[m
[32m+[m[32m                                        "stream-shift": {[m
[32m+[m[32m                                            "version": "1.0.0",[m
[32m+[m[32m                                            "bundled": true[m
[32m+[m[32m                                        }[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                },[m
[32m+[m[32m                                "end-of-stream": {[m
[32m+[m[32m                                    "version": "1.4.1",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "once": "1.4.0"[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                },[m
[32m+[m[32m                                "flush-write-stream": {[m
[32m+[m[32m                                    "version": "1.0.2",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "inherits": "2.0.3",[m
[32m+[m[32m                                        "readable-stream": "2.3.5"[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                },[m
[32m+[m[32m                                "from2": {[m
[32m+[m[32m                                    "version": "2.3.0",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "inherits": "2.0.3",[m
[32m+[m[32m                                        "readable-stream": "2.3.5"[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                },[m
[32m+[m[32m                                "parallel-transform": {[m
[32m+[m[32m                                    "version": "1.1.0",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "cyclist": "0.2.2",[m
[32m+[m[32m                                        "inherits": "2.0.3",[m
[32m+[m[32m                                        "readable-stream": "2.3.5"[m
[32m+[m[32m                                    },[m
[32m+[m[32m                                    "dependencies": {[m
[32m+[m[32m                                        "cyclist": {[m
[32m+[m[32m                                            "version": "0.2.2",[m
[32m+[m[32m                                            "bundled": true[m
[32m+[m[32m                                        }[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                },[m
[32m+[m[32m                                "pump": {[m
[32m+[m[32m                                    "version": "2.0.1",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "end-of-stream": "1.4.1",[m
[32m+[m[32m                                        "once": "1.4.0"[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                },[m
[32m+[m[32m                                "pumpify": {[m
[32m+[m[32m                                    "version": "1.4.0",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "duplexify": "3.5.4",[m
[32m+[m[32m                                        "inherits": "2.0.3",[m
[32m+[m[32m                                        "pump": "2.0.1"[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                },[m
[32m+[m[32m                                "stream-each": {[m
[32m+[m[32m                                    "version": "1.2.2",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "end-of-stream": "1.4.1",[m
[32m+[m[32m                                        "stream-shift": "1.0.0"[m
[32m+[m[32m                                    },[m
[32m+[m[32m                                    "dependencies": {[m
[32m+[m[32m                                        "stream-shift": {[m
[32m+[m[32m                                            "version": "1.0.0",[m
[32m+[m[32m                                            "bundled": true[m
[32m+[m[32m                                        }[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                },[m
[32m+[m[32m                                "through2": {[m
[32m+[m[32m                                    "version": "2.0.3",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "readable-stream": "2.3.5",[m
[32m+[m[32m                                        "xtend": "4.0.1"[m
[32m+[m[32m                                    },[m
[32m+[m[32m                                    "dependencies": {[m
[32m+[m[32m                                        "xtend": {[m
[32m+[m[32m                                            "version": "4.0.1",[m
[32m+[m[32m                                            "bundled": true[m
[32m+[m[32m                                        }[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                }[m
[32m+[m[32m                            }[m
[32m+[m[32m                        },[m
[32m+[m[32m                        "y18n": {[m
[32m+[m[32m                            "version": "4.0.0",[m
[32m+[m[32m                            "bundled": true[m
[32m+[m[32m                        }[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "call-limit": {[m
[32m+[m[32m                    "version": "1.1.0",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "chownr": {[m
[32m+[m[32m                    "version": "1.0.1",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "cli-table2": {[m
[32m+[m[32m                    "version": "0.2.0",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "colors": "1.1.2",[m
[32m+[m[32m                        "lodash": "3.10.1",[m
[32m+[m[32m                        "string-width": "1.0.2"[m
[32m+[m[32m                    },[m
[32m+[m[32m                    "dependencies": {[m
[32m+[m[32m                        "colors": {[m
[32m+[m[32m                            "version": "1.1.2",[m
[32m+[m[32m                            "bundled": true,[m
[32m+[m[32m                            "optional": true[m
[32m+[m[32m                        },[m
[32m+[m[32m                        "lodash": {[m
[32m+[m[32m                            "version": "3.10.1",[m
[32m+[m[32m                            "bundled": true[m
[32m+[m[32m                        },[m
[32m+[m[32m                        "string-width": {[m
[32m+[m[32m                            "version": "1.0.2",[m
[32m+[m[32m                            "bundled": true,[m
[32m+[m[32m                            "requires": {[m
[32m+[m[32m                                "code-point-at": "1.1.0",[m
[32m+[m[32m                                "is-fullwidth-code-point": "1.0.0",[m
[32m+[m[32m                                "strip-ansi": "3.0.1"[m
[32m+[m[32m                            },[m
[32m+[m[32m                            "dependencies": {[m
[32m+[m[32m                                "code-point-at": {[m
[32m+[m[32m                                    "version": "1.1.0",[m
[32m+[m[32m                                    "bundled": true[m
[32m+[m[32m                                },[m
[32m+[m[32m                                "is-fullwidth-code-point": {[m
[32m+[m[32m                                    "version": "1.0.0",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "number-is-nan": "1.0.1"[m
[32m+[m[32m                                    },[m
[32m+[m[32m                                    "dependencies": {[m
[32m+[m[32m                                        "number-is-nan": {[m
[32m+[m[32m                                            "version": "1.0.1",[m
[32m+[m[32m                                            "bundled": true[m
[32m+[m[32m                                        }[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                },[m
[32m+[m[32m                                "strip-ansi": {[m
[32m+[m[32m                                    "version": "3.0.1",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "ansi-regex": "2.1.1"[m
[32m+[m[32m                                    },[m
[32m+[m[32m                                    "dependencies": {[m
[32m+[m[32m                                        "ansi-regex": {[m
[32m+[m[32m                                            "version": "2.1.1",[m
[32m+[m[32m                                            "bundled": true[m
[32m+[m[32m                                        }[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                }[m
[32m+[m[32m                            }[m
[32m+[m[32m                        }[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "cmd-shim": {[m
[32m+[m[32m                    "version": "2.0.2",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "graceful-fs": "4.1.11",[m
[32m+[m[32m                        "mkdirp": "0.5.1"[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "columnify": {[m
[32m+[m[32m                    "version": "1.5.4",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "strip-ansi": "3.0.1",[m
[32m+[m[32m                        "wcwidth": "1.0.1"[m
[32m+[m[32m                    },[m
[32m+[m[32m                    "dependencies": {[m
[32m+[m[32m                        "strip-ansi": {[m
[32m+[m[32m                            "version": "3.0.1",[m
[32m+[m[32m                            "bundled": true,[m
[32m+[m[32m                            "requires": {[m
[32m+[m[32m                                "ansi-regex": "2.1.1"[m
[32m+[m[32m                            },[m
[32m+[m[32m                            "dependencies": {[m
[32m+[m[32m                                "ansi-regex": {[m
[32m+[m[32m                                    "version": "2.1.1",[m
[32m+[m[32m                                    "bundled": true[m
[32m+[m[32m                                }[m
[32m+[m[32m                            }[m
[32m+[m[32m                        },[m
[32m+[m[32m                        "wcwidth": {[m
[32m+[m[32m                            "version": "1.0.1",[m
[32m+[m[32m                            "bundled": true,[m
[32m+[m[32m                            "requires": {[m
[32m+[m[32m                                "defaults": "1.0.3"[m
[32m+[m[32m                            },[m
[32m+[m[32m                            "dependencies": {[m
[32m+[m[32m                                "defaults": {[m
[32m+[m[32m                                    "version": "1.0.3",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "clone": "1.0.2"[m
[32m+[m[32m                                    },[m
[32m+[m[32m                                    "dependencies": {[m
[32m+[m[32m                                        "clone": {[m
[32m+[m[32m                                            "version": "1.0.2",[m
[32m+[m[32m                                            "bundled": true[m
[32m+[m[32m                                        }[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                }[m
[32m+[m[32m                            }[m
[32m+[m[32m                        }[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "config-chain": {[m
[32m+[m[32m                    "version": "1.1.11",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "ini": "1.3.5",[m
[32m+[m[32m                        "proto-list": "1.2.4"[m
[32m+[m[32m                    },[m
[32m+[m[32m                    "dependencies": {[m
[32m+[m[32m                        "proto-list": {[m
[32m+[m[32m                            "version": "1.2.4",[m
[32m+[m[32m                            "bundled": true[m
[32m+[m[32m                        }[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "debuglog": {[m
[32m+[m[32m                    "version": "1.0.1",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "detect-indent": {[m
[32m+[m[32m                    "version": "5.0.0",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "detect-newline": {[m
[32m+[m[32m                    "version": "2.1.0",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "dezalgo": {[m
[32m+[m[32m                    "version": "1.0.3",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "asap": "2.0.5",[m
[32m+[m[32m                        "wrappy": "1.0.2"[m
[32m+[m[32m                    },[m
[32m+[m[32m                    "dependencies": {[m
[32m+[m[32m                        "asap": {[m
[32m+[m[32m                            "version": "2.0.5",[m
[32m+[m[32m                            "bundled": true[m
[32m+[m[32m                        }[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "editor": {[m
[32m+[m[32m                    "version": "1.0.0",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "find-npm-prefix": {[m
[32m+[m[32m                    "version": "1.0.2",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "fs-vacuum": {[m
[32m+[m[32m                    "version": "1.2.10",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "graceful-fs": "4.1.11",[m
[32m+[m[32m                        "path-is-inside": "1.0.2",[m
[32m+[m[32m                        "rimraf": "2.6.2"[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "fs-write-stream-atomic": {[m
[32m+[m[32m                    "version": "1.0.10",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "graceful-fs": "4.1.11",[m
[32m+[m[32m                        "iferr": "0.1.5",[m
[32m+[m[32m                        "imurmurhash": "0.1.4",[m
[32m+[m[32m                        "readable-stream": "2.3.5"[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "gentle-fs": {[m
[32m+[m[32m                    "version": "2.0.1",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "aproba": "1.2.0",[m
[32m+[m[32m                        "fs-vacuum": "1.2.10",[m
[32m+[m[32m                        "graceful-fs": "4.1.11",[m
[32m+[m[32m                        "iferr": "0.1.5",[m
[32m+[m[32m                        "mkdirp": "0.5.1",[m
[32m+[m[32m                        "path-is-inside": "1.0.2",[m
[32m+[m[32m                        "read-cmd-shim": "1.0.1",[m
[32m+[m[32m                        "slide": "1.1.6"[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "glob": {[m
[32m+[m[32m                    "version": "7.1.2",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "fs.realpath": "1.0.0",[m
[32m+[m[32m                        "inflight": "1.0.6",[m
[32m+[m[32m                        "inherits": "2.0.3",[m
[32m+[m[32m                        "minimatch": "3.0.4",[m
[32m+[m[32m                        "once": "1.4.0",[m
[32m+[m[32m                        "path-is-absolute": "1.0.1"[m
[32m+[m[32m                    },[m
[32m+[m[32m                    "dependencies": {[m
[32m+[m[32m                        "fs.realpath": {[m
[32m+[m[32m                            "version": "1.0.0",[m
[32m+[m[32m                            "bundled": true[m
[32m+[m[32m                        },[m
[32m+[m[32m                        "minimatch": {[m
[32m+[m[32m                            "version": "3.0.4",[m
[32m+[m[32m                            "bundled": true,[m
[32m+[m[32m                            "requires": {[m
[32m+[m[32m                                "brace-expansion": "1.1.8"[m
[32m+[m[32m                            },[m
[32m+[m[32m                            "dependencies": {[m
[32m+[m[32m                                "brace-expansion": {[m
[32m+[m[32m                                    "version": "1.1.8",[m
[32m+[m[32m                                    "bundled": true,[m
[32m+[m[32m                                    "requires": {[m
[32m+[m[32m                                        "balanced-match": "1.0.0",[m
[32m+[m[32m                                        "concat-map": "0.0.1"[m
[32m+[m[32m                                    },[m
[32m+[m[32m                                    "dependencies": {[m
[32m+[m[32m                                        "balanced-match": {[m
[32m+[m[32m                                            "version": "1.0.0",[m
[32m+[m[32m                                            "bundled": true[m
[32m+[m[32m                                        },[m
[32m+[m[32m                                        "concat-map": {[m
[32m+[m[32m                                            "version": "0.0.1",[m
[32m+[m[32m                                            "bundled": true[m
[32m+[m[32m                                        }[m
[32m+[m[32m                                    }[m
[32m+[m[32m                                }[m
[32m+[m[32m                            }[m
[32m+[m[32m                        },[m
[32m+[m[32m                        "path-is-absolute": {[m
[32m+[m[32m                            "version": "1.0.1",[m
[32m+[m[32m                            "bundled": true[m
[32m+[m[32m                        }[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "graceful-fs": {[m
[32m+[m[32m                    "version": "4.1.11",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "has-unicode": {[m
[32m+[m[32m                    "version": "2.0.1",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "hosted-git-info": {[m
[32m+[m[32m                    "version": "2.6.0",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "iferr": {[m
[32m+[m[32m                    "version": "0.1.5",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "imurmurhash": {[m
[32m+[m[32m                    "version": "0.1.4",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "inflight": {[m
[32m+[m[32m                    "version": "1.0.6",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "once": "1.4.0",[m
[32m+[m[32m                        "wrappy": "1.0.2"[m
[32m+[m[32m                    }[m
[32m+[m[32m                },[m
[32m+[m[32m                "inherits": {[m
[32m+[m[32m                    "version": "2.0.3",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "ini": {[m
[32m+[m[32m                    "version": "1.3.5",[m
[32m+[m[32m                    "bundled": true[m
[32m+[m[32m                },[m
[32m+[m[32m                "init-package-json": {[m
[32m+[m[32m                    "version": "1.10.3",[m
[32m+[m[32m                    "bundled": true,[m
[32m+[m[32m                    "requires": {[m
[32m+[m[32m                        "glob": "7.1.2",[m
[32m+[m[32m                        "npm-package-arg": "6.0.0",[m
[32m+[m[32m                        "promzard": "0.3.0",[m
[32m+[m[32m                        "read": "1.0.7",[m
[32m+[m[32m                        "read-package-json": "2.0.13",[m
[32m+[m[32m                        "semver": "5.5.0",[m
[32m+[m[32m                        "validate-npm-package-license": "3.0.1",[m
[32m+[m[32m                        "validate-npm-package-name": "3.0.0"[m
[32m+[m[32m         
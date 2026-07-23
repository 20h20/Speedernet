module.exports = function (grunt) {
  require("time-grunt")(grunt);
  require("jit-grunt")(grunt);

  
  grunt.initConfig({
    theme_name: "speedernet",

    /* Chemin pour les blocks */
    path_src_blocks: "templates/blocks/",
    path_dist_blocks: "library/css/blocks/",

    /* Chemin pour les parts */
    path_src_parts: "templates/parts/",
    path_dist_parts: "library/css/parts/",

    /* Chemin pour les styles globaux */
    path_src_styles: "src/scss/",
    path_dist_styles: "library/css/",

    /* Chemin pour les js et icons */
    path_src: "src/",
    path_dist: "library/",
    pkg: grunt.file.readJSON("package.json"),

    /* ------------------------ */
    /*   SASS : Blocks & Parts  */
    /* ------------------------ */
    sass: {
      blocks: {
        expand: true,
        cwd: "<%= path_src_blocks %>",
        src: ["**/style.scss", "!style.scss"],
        dest: "<%= path_dist_blocks %>",
        rename: function (dest, src) {
          var blockName = src.split("/")[src.split("/").length - 2];
          return dest + blockName + ".min.css";
        },
        options: {
          implementation: require('node-sass'),
          sourceMap: false
        }
      },

      parts: {
        expand: true,
        cwd: "<%= path_src_parts %>",
        src: ["**/style.scss", "!style.scss"],
        dest: "<%= path_dist_parts %>",
        rename: function (dest, src) {
          var name = src.split("/")[src.split("/").length - 2];
          return dest + name + ".min.css";
        },
        options: {
          implementation: require("node-sass"),
          sourceMap: false
        }
      },

      admin: {
        src: "<%= path_src_styles %>admin.scss",
        dest: "<%= path_dist_styles %>admin.min.css",
        options: { sourceMap: false }
      },

      global: {
        src: "<%= path_src_styles %>style.scss",
        dest: "<%= path_dist_styles %>style.min.css",
        options: {
          sourceMap: false,
        }
      }
    },

    /* ------------------------ */
    /*   POSTCSS : Blocks/Parts */
    /* ------------------------ */
    postcss: {
      options: {
        map: false,
        processors: [
          require("autoprefixer")({ overrideBrowserslist: "last 3 versions" }),
          require("cssnano")({ reduceIdents: false })
        ]
      },

      blocks: {
        src: "<%= path_dist_blocks %>*.css"
      },

      parts: {
        src: "<%= path_dist_parts %>*.css"
      },

      admin: {
        src: "<%= path_dist_styles %>admin.min.css",
        dest: "<%= path_dist_styles %>admin.min.css"
      },

      global: {
        src: "<%= path_dist_styles %>style.min.css",
        dest: "<%= path_dist_styles %>style.min.css"
      }
    },

    /* ------------------------ */
    /*    GUTENBERG MERGE CSS   */
    /* ------------------------ */
    concat: {
      options: { separator: ";" },
      gutenberg: {
        src: ["<%= path_dist_blocks %>*.css"],
        dest: "<%= path_dist_styles %>gutenberg.min.css"
      },
      dist: {
        src: ["<%= path_src %>js/**/*.js"],
        dest: "<%= path_dist %>js/scripts.js"
      }
    },

    /* Icons font */
    webfont: {
      icons: {
        src: "<%= path_src %>icons/*.svg",
        dest: "<%= path_dist %>iconfont",
        destCss: "<%= path_src %>scss/partials/",
        options: {
          stylesheet: "scss",
          relativeFontPath: "../iconfont",
          template: "<%= path_src %>scss/partials/_icons-template.scss",
          types: "eot,woff,ttf,svg",
          htmlDemo: false,
          optimize: false,
          engine: "node",
          autoHint: false
        }
      }
    },
  
    /* Javascript Inclusions */
    include_file: {
      default_options: {
        cwd: "<%= path_src %>js/",
        src: ["scripts.js"],
        dest: "<%= path_dist %>js/"
      }
    },

    /* Javascript Uglify */
    uglify: {
      app: {
        files: {
          "<%= path_dist %>js/scripts.js": ["<%= path_dist %>js/scripts.js"]
        }
      }
    },

    /* ------------------------ */
    /*       WATCH TASKS        */
    /* ------------------------ */
    watch: {
      options: { spawn: false },

      iconfont: {
        files: "<%= path_src %>icons/*.svg",
        tasks: ["webfont"]
      },

      blocks: {
        files: ["<%= path_src_blocks %>**/*.scss"],
        tasks: ["sass:blocks", "postcss:blocks", "concat:gutenberg"]
      },

      parts: {
        files: ["<%= path_src_parts %>**/*.scss"],
        tasks: ["sass:parts", "postcss:parts"]
      },

      admin: {
        files: ["<%= path_src %>scss/components/micros/_back-office.scss"],
        tasks: ["sass:admin", "postcss:admin"]
      },

      global: {
        files: ["<%= path_src %>**/*.scss"],
        tasks: ["sass:global", "postcss:global"]
      },

      js: {
        files: ["<%= path_src %>js/**/*.js", "<%= path_src_blocks %>**/*.js", "<%= path_src_parts %>**/*.js"],
        tasks: ["include_file", "uglify"]
      }
    }

  });

  /* ------------------------ */
  /*     LOAD TASKS           */
  /* ------------------------ */
  grunt.loadNpmTasks("grunt-contrib-watch");
  grunt.loadNpmTasks("grunt-contrib-concat");
  grunt.loadNpmTasks("grunt-sass");
  grunt.loadNpmTasks("grunt-postcss");

  /* ------------------------ */
  /*       DEFAULT            */
  /* ------------------------ */
  grunt.registerTask("default", [
    "sass:blocks", "sass:parts", "sass:global", "sass:admin",
    "postcss:blocks", "postcss:parts", "postcss:global", "postcss:admin",
    "concat:gutenberg",
    "webfont",
    "include_file",
    "uglify",
    "watch"
  ]);

  /* ------------------------ */
  /*        BUILD             */
  /* ------------------------ */
  grunt.registerTask("build", [
    "sass:blocks", "sass:parts", "sass:global",
    "postcss:blocks", "postcss:parts", "postcss:global",
    "concat:gutenberg",
    "webfont",
    "include_file",
    "uglify"
  ]);
};
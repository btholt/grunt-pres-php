#shell
npm init

---

#package.json
add private to npm

---

#shell
npm install --save-dev grunt
npm install --save-dev grunt-contrib-less

#Gruntfile.js
grunt.loadNpmTasks('grunt-contrib-less');

less: {
  dev: {
    options: {
      cleancss: true
    },
    files: {
      'style.css' : 'style.less'
    }
  }
}

---

#shell
npm install --save-dev grunt-contrib-watch

#Gruntfile.js
grunt.loadNpmTasks('grunt-contrib-less');

watch: {
  lessCompile: {
    files: '**/*.less',
    tasks: ['less'],
    options: {
      livereload: true
    }
  }

}

---

#shell
npm install --save-dev grunt-phplint

#Gruntfile.js
grunt.loadNpmTasks('grunt-phplint');

phplint: {
  app: ['app.php']
},

phpWatch: {
  files: ['<%= phplint.app %>', '<%= phplint.testing %>'],
  tasks: ['phplint'],
  options: {
    livereload: true
  }
}

---

#shell
npm install --save-dev grunt-phpunuit

#Gruntfile.js
grunt.loadNpmTasks('grunt-phpunit);

phpunit: {
  classes: {
      dir: 'test/'
  },
  options: {
      colors: true
  }
},

tasks: ['phplint', 'phpunit'],

---

#Gruntfile.js
grunt.registerTask('php', ['phplint', 'phpunit']);
grunt.registerTask('default', ['less', 'phplint', 'phpunit']);
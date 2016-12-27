# Boolfuck

My implementations of the [Boolfuck](http://samuelhughes.com/boof/index.html) Interpreter, tested thoroughly against an extensive set of test cases on [Codewars](http://codewars.com).  FreeBSD 2-Clause Licensed.

## Interpreters

Each of my implementations of the Interpreter in each language is placed in a separate folder on its own according to the name/acronym of the language.  For example, the Boolfuck interpreter in JavaScript is placed in a folder called `js`.  Each folder may or may not come with a set of test cases but note that either way, each interpreter has been thoroughly tested beforehand.


### JavaScript

```javascript
var output = boolfuck(code[, input = ""]);
```

The interpreter is a function `boolfuck()` which receives up to 2 arguments.  The first (required) argument is the Boolfuck program to be interpreted as a string and the second (optional) argument is the **end-user** input which is also passed in as a string.  The **character** output is returned as a string.

# Boolfuck

My implementations of the [Boolfuck](http://samuelhughes.com/boof/index.html) Interpreter, tested thoroughly against an extensive set of test cases on [Codewars](http://codewars.com).  FreeBSD 2-Clause Licensed.

## Interpreters

Each of my implementations of the Interpreter in each language is placed in a separate folder on its own according to the name/acronym of the language.  For example, the Boolfuck interpreter in JavaScript is placed in a folder called `js`.  Each folder may or may not come with a set of test cases but note that either way, each interpreter has been thoroughly tested beforehand.


### JavaScript

```javascript
var output = boolfuck(code[, input = ""]);
```

The interpreter is a function `boolfuck()` which receives up to 2 arguments.  The first (required) argument is the Boolfuck program to be interpreted as a string and the second (optional) argument is the **end-user** input which is also passed in as a string.  The **character** output is returned as a string.

### PHP

- Interpreter: `function.boolfuck.php`
- Full suite of test cases (powered by [PHPTester](https://github.com/DonaldKellett/PHPTester)): `test_cases.php`
- Extras - Brainfuck to Boolfuck Converter: `function.brainfuck-to-boolfuck.php`

#### The Interpreter

```php
string boolfuck(string $code[, string $input = ""])
```

The interpreter is a function `boolfuck()` which receives up to 2 arguments.  The first (required) argument is the Boolfuck program to be executed, passed in as a string.  Comments (i.e. non-command characters) are supported and are simply ignored by the interpreter.  The second (optional) argument is the **end-user** program input (as defined by the [official website](http://samuelhughes.com/boof/index.html)) passed in as a string.  If the second argument is not specified/provided, it defaults to an empty string.

#### The Test Cases

Powered by [PHPTester](https://github.com/DonaldKellett/PHPTester), the test cases test the ability of the interpreter to properly interpret any valid Boolfuck program as per the specification outlined on the [official website](http://samuelhughes.com/boof/index.html) by testing it against a large number of different Boolfuck programs including but not limited to the "Hello World" program provided by the official website and a Fibonacci program/algorithm translated directly from Brainfuck code as per the translation instructions provided directly by the official website.  Note, however, that since a typical Boolfuck program (especially those translated directly from Brainfuck code) contains *way* more commands than that of a typical Brainfuck program (and a significantly useful Brainfuck program typically takes a number of milliseconds to interpret!), the test cases provided in this repo may take a while to execute so please be patient.  For example, I executed the test cases in my local MAMP server and it took about 15 seconds to complete.  Faster servers may take less time to execute the code (for example, Codewars Red Servers take only about 3 seconds to execute the entire test suite).

#### Extras - The Converter

```php
string brainfuck_to_boolfuck(string $brainfuck)
```

The function receives 1 required argument which is the Brainfuck code to be converted.  The return value is the Boolfuck equivalent of the Brainfuck program passed in as per the translation specification on the official website *with no optimizations* and as a string.  Any and all non-command characters in the Brainfuck code are removed.

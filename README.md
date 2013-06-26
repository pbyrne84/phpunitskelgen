# phpunitskelgen - a skeleton generator for generating unit tests.
One of the main issues with TDD is the manual effort that must be repeated at the start of each new test case. This in
turn can lead to classes growing large due to the hassle of create a new test case when sprouting a class. This makes it almost as easy to create
a new class for new functionality than it to try and lump it into another class( Inline Class is quite a rare refactoring as class tend to always
go from thin to fat due to the effort, reduce effort than more experimentation in TDD can be allowed due to time restraints ). Just create a class
in a namespaced with a type hinted contructor and call the external tool.


## Features:
1. All customisable implementation is injected via constructor so IDE features, subfolder creation, adding to Version Control, use of namespaces on legacy code,
code construction etc. can be overriden

2. Analyses constructor parameters to generate mocks from.

3. Current internal configuration relies on Phockito/PhpUnit for mocking but this can be ovveriden for any test framework/mocking framework. Originally this
was used internally but refactored out to make generic and generated PhpUnit mocks.

4. External tool configuration is farely generic but the implemented mask to calculate class name is namespaced specific. This did use to hook in to PhpStorm
very nicely but they removed the PHP skelgen feature for a java only one.

5. Internal templating method uses XSLT but this can be overriden and all it is doing is rendered a list of calculated

6. Custom base test case on the inheritance of the class to be tested is also very easy to implement as it all relies on
two levels of chaining.
a:) Matching to a project
b:) Matching to a base test case for that project

The amount of work required depends on the organisation differential in the projects this is applied to.

```php


\\\


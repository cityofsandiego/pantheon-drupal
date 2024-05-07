### MODULE: custom_linkablebrs

### INTRODUCTION

Inserting link with <br> creates two links issue #14972.  If you create text with a line break in it, it will create two links instead of one.

#### Example : 

Create a link highlighting this text:  "line 1<br> line 2"

Expected result is that the whole text would be one link:
  <a href="https://google.com> line 1<br> line 2</a>

Actual result
<p>
    <a href="https://google.com">line 1</a><br>
    <a href="https://google.com">line 2</a>
</p>

#### See
https://github.com/ckeditor/ckeditor5/issues/14972
https://github.com/ckeditor/ckeditor5/issues/1068


### INSTALLATION
Enable module.


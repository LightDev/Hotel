<html xmlns=http://www.w3.org/1999/xhtml
      xmlns:xforms="http://www.w3.org/2002/xforms/cr"> 

    <head>

        <!-- define the form model -->
        <xforms:model id="enter">
            <xforms:instance>
                <user>
                    <name />
                </user>
            </xforms:instance>
        </xforms:model>

        <basefont face="Arial">
    </head>

    <body>
        <font size="+1">
            What's In A Name?
        </font><br /><br />

        <!-- define the form interface -->
        <xforms:input id="txtname" 
                      model="enter" ref="/user/name">
            <xforms:label>Name</xforms:label>
            <xforms:hint>
                Enter your name, then press TAB
            </xforms:hint>
        </xforms:input>

        <br />

        <!-- do something with the input -->
        Welcome to XForms, 
        <xforms:output model="enter" 
                       ref="/user/name" />

    </body>
</html>
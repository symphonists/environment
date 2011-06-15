# Environment #
 
Version: 1.0.0  
Author: [Max Wheeler](http://makenosound.com)  
Build Date: 2011-06-15  
Compatibility: Symphony 2.2+

Adds a preference to expose the current environment as a parameter.

## Installation ##

Clone this repository into a folder called `environment` in your `/extensions/` directory. Something akin to:

    git clone https://github.com/makenosound/symphony-environment.git extensions/environment

## Usage ##

Once you set the environment in your preferences you can use it in your templates to target specific environments. For example, you probably don't want to have your Google Analytics code on your development or staging sites. This extension lets you easily differentiate between the two and only serve GA code up to the production site:

    <xsl:if test="$environment = 'production'">
      <!-- Insert tracking code -->
    </xsl:if>
<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="3.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:atom="http://www.w3.org/2005/Atom" xmlns:dc="http://purl.org/dc/elements/1.1/"
                xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd">
  <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
  <xsl:variable name="settings-data" select="document('/pretty-rss/pretty-rss-settings.xml')"/>
  <xsl:template match="/">
    <html xmlns="http://www.w3.org/1999/xhtml" lang="en">
      <head>
        <title><xsl:value-of select="/rss/channel/title"/></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <link rel="stylesheet" href="/pretty-rss/pretty-rss.css"/>
        <style>
        body{
          background-color: <xsl:value-of select="$settings-data/settings/background-color"/>;
          color: <xsl:value-of select="$settings-data/settings/text-color"/>;

        }
        small{
          color: <xsl:value-of select="$settings-data/settings/text-color"/>;
        }
        h1, h2, h3, h4, h5, h6 { 
          color: <xsl:value-of select="$settings-data/settings/header-color"/>; 
        }
        a { 
          color: <xsl:value-of select="$settings-data/settings/link-color"/>; 
        }
        a:hover { 
          color: <xsl:value-of select="$settings-data/settings/hover-color"/>; 
        }
        header {
          background-color: <xsl:value-of select="$settings-data/settings/site-info-bg"/>;
          border-bottom: 0.25rem solid color-mix(in srgb, <xsl:value-of select="$settings-data/settings/site-info-bg"/>, black 30%);
        }
        header h1, header h2, header a, header a:hover, .feed-description{
          color: <xsl:value-of select="$settings-data/settings/site-info-text"/>;
        }
        header a:hover{
          text-decoration: underline; 
        }
      </style>
      </head>
      <body>
        <xsl:if test="number($settings-data/settings/hide-intro) = 0">
          <nav class="intro">
            <div class="container">
              <div class="intro-logo">
              <!-- https://commons.wikimedia.org/wiki/File:Feed-icon.svg -->
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" class="rss-icon" id="RSSicon" viewBox="0 0 256 256">
                  <defs>
                    <linearGradient x1="0.085" y1="0.085" x2="0.915" y2="0.915" id="RSSg">
                      <stop  offset="0.0" stop-color="#E3702D"/><stop  offset="0.1071" stop-color="#EA7D31"/>
                      <stop  offset="0.3503" stop-color="#F69537"/><stop  offset="0.5" stop-color="#FB9E3A"/>
                      <stop  offset="0.7016" stop-color="#EA7C31"/><stop  offset="0.8866" stop-color="#DE642B"/>
                      <stop  offset="1.0" stop-color="#D95B29"/>
                    </linearGradient>
                  </defs>
                  <rect width="256" height="256" rx="55" ry="55" x="0"  y="0"  fill="#CC5D15"/>
                  <rect width="246" height="246" rx="50" ry="50" x="5"  y="5"  fill="#F49C52"/>
                  <rect width="236" height="236" rx="47" ry="47" x="10" y="10" fill="url(#RSSg)"/>
                  <circle cx="68" cy="189" r="24" fill="#FFF"/>
                  <path d="M160 213h-34a82 82 0 0 0 -82 -82v-34a116 116 0 0 1 116 116z" fill="#FFF"/>
                  <path d="M184 213A140 140 0 0 0 44 73 V 38a175 175 0 0 1 175 175z" fill="#FFF"/>
                </svg>
                </div>
                <div class="intro-text">
                <p>
                This is a preview of this site's feed, also known as an RSS feed. Add the URL of this page (<code><xsl:value-of select="$settings-data/settings/feed-url"/></code>) to your feed reader to subscribe.
                </p>
                <xsl:if test="$settings-data/settings/about-feed-link = '1'">
                  <p class="about-feed-link">
                    Visit <a href="https://aboutfeeds.com">About Feeds</a> to get started with newsreaders and subscribing. It's free.
                  </p>
               </xsl:if>
                </div>
            </div>
          </nav>
        </xsl:if>
        <header>
          <div class="container">
            <h1><xsl:value-of select="$settings-data/settings/title"/></h1>
            <div class="site-info">
            <xsl:if test="normalize-space($settings-data/settings/site-icon)">

                <div class="site-icon">
                  <img>
                  <xsl:attribute name="src">
                    <xsl:value-of select="$settings-data/settings/site-icon"/>
                  </xsl:attribute>
                  </img>
                </div>
              </xsl:if>
              <div class="site-details">
                <h2 class="feed-title"><xsl:value-of select="/rss/channel/title"/></h2>
                <xsl:if test="normalize-space(/rss/channel/description)">
                  <p class="feed-description"><xsl:value-of select="/rss/channel/description"/></p>
                </xsl:if>
                <a class="site-link" target="_blank">
                <xsl:attribute name="href">
                  <xsl:value-of select="/rss/channel/link"/>
                </xsl:attribute>
                Visit Website &#x2192;
              </a>
              </div>
            </div>
          </div>
        </header>
          <div class="container recent">
          <h2>Recent Items</h2>
          <xsl:for-each select="/rss/channel/item">
            <div class="item">
              <h3>
                <a target="_blank">
                  <xsl:attribute name="href">
                    <xsl:value-of select="link"/>
                  </xsl:attribute>
                  <xsl:value-of select="title"/>
                </a>
              </h3>
              <small>Published: <xsl:value-of select="pubDate" /></small>
            </div>
          </xsl:for-each>
        </div>
      </body>
    </html>
  </xsl:template>
</xsl:stylesheet>

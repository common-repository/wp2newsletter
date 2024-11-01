=== Wp2Newsletter ===
Contributors: webavenue
Tags: wordpress plugin , mailchimp, newsletter, newsletter campaign, email to newsletter, post types, newsletter templates, mailchimp templates, GetResponse, Campaign Monitor, Email Marketing, newsletter service,

Requires at least: 3.0.1
Tested up to: 4.4.1
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Wp2Newsletter provides RSS feed URL for your newsletter campaign and generate newsletter from Wordpress post type contents .


== Description ==

If you want your Wordpress site to reach out to every user, you need to create newsletter campaigns. Wp2Newsletter plugin helps create a datasource from all your Wordpress post types for your newsletter setup, generate RSS feed URL that is ready to feed into RSS based mail chimp campaign, link with email marketing service provider (Mailchimp in this version) and publish the newsletter automatically with very less effort.<br>

Pull contents from your post types , filter your contents, choose the available templates for your newsletter, link marketing service provider using their api key , preview your newsletter and finally publish all from your Wordpress dashboard.

With this version, you are able to
Pull and filter contents from any available or custom post types of your Wordpress site.
Choose the available EDM templates which include both RSS driven or normal EDM templates. (Additional templates in paid versions)
Link Wordpress email marketing service provider (additional providers such as GetResponse, Campaign Monitor in paid versions) using its API key
Preview html code or visual contents before you publish.
Automatically generate newsletter in your Mailchimp account.

Many post types<br>
This plugin supports any post types available for Wordpress posts, pages, custom post types and so on<br>

Filter options<br>
In order to create data sources for your newsletter, many data source filter options are available like Excluding posts, Order by, Sort order, Max no of items, Content Length and Date Format.<br>

Preview templates<br>
You can preview EDM templates before you decide which template to use for your newsletter. You can either use visual editor or html code editor. <br>

Preview your newsletter<br>
Similar to EDM templates, you can also preview your newsletter after you have chosen your data source and EDM template type.<br> 

== Installation ==
<Strong>Automatic Installation</Strong><br>
Log in to your site and go to the Plugins page.<br>
Click Add New button.<br>
Search for WP2Newsletter <br>
Click Install Now link.<br>
Click Activate Plugin link.<br>
If you want to push your datasource automatically to Mailchimp,<br>
Obtain your MailChimp API Key by logging into mailchimp.com, click My Account, click extras and choose API Keys in the drop down and copy the API Key code. If the API Key code  is missing, click the link to "generate your API key" first.<br>
Back on your site, click Wp2Newsletter and click settings tab on the administration sidebar menu.. Check to ensure that your API key is properly configured.<br>

<Strong>Manual Installation</Strong><br>
Download the Plugin and un-zip it.<br>
Upload the Wp2Newsletter folder to your wp-content/plugins/directory.<br>
Activate the Plugin through the Plugins menu in WordPress.<br>
If you want to push your datasource automatically to Mailchimp,<br>
Obtain your Mailchimp API Key by logging into mailchimp.com, click My Account, click extras and choose API Keys in the drop down and copy the API Key code. If the API Key code  is missing, click the link to "generate your API key" first.<br>
Back on your site, click Wp2Newsletter and click settings tab on the administration sidebar menu.. Check to ensure that your API key is properly configured.<br>




== Frequently Asked Questions ==

Q1: How do I install this plugin?<br>
Steps of installing  this plugin is explained in Installation section

Q2: How do I set up MailChimp API Key?<br>
Obtain your Mailchimp API Key by logging into mailchimp.com, click My Account, click extras and choose API Keys in the drop down and copy the API Key code. If the API Key code  is missing, click the link to "generate your API key" first.Back on your site, click Wp2Newsletter and click settings tab on the administration sidebar menu.. Check to ensure that your API key is properly configured.

Q3: How do I add data source?<br>
Go to Wp2Newsletter and click New Data Source. There are 2 sections to fill while adding new data source. <br>
After entering title, in Setup Newsletter Data Source Section, add description, select data source from the drop down list (Here only those data source list or post types are displayed that are enabled/checked in data source list of Wp2Newsletter ->Settings  section), narrow down your data source by choosing data types and also you can choose the hero post to be displayed in your newsletter.<br>
In Settings section, you can further use settings to alter your newsletter format like Excluding posts, Order by, Sort order, Max no of items, Content Length and Date Format.

Q4: How do I generate RSS feed URL<br>
After you add datasource, go to the list of data sources Wp2Newsletter -> Data Sources <br>
Click "View" in your chosen datasource <br>
RSS feed URL will be generated which you can paste in MailChimp RSS campaign<br>


Q5: How do I generate newsletter?<br>
Go to Wp2Newsletter and click Generate Newsletter<br>
Enter Template Name<br>
Choose Template Type (Choose either RSS driven or Normal Template type depending on your need)<br>
Select Data Source ( Select the data source you want your newsletter to be made of )<br>
Generate Preview (You can preview on how your final newsletter would look like either visually or in html code editor)<br>
Create New Template ( If your preview is ok, you can finally create newsletter by clicking Create New Template). You can see this template in the list of templates of your mailchimp account automatically. <br>

Q6: How do create an RSS campaign in Mailchimp?<br>
Go to http://kb.mailchimp.com/campaigns/rss-in-campaigns/create-an-rss-campaign <br>
You can insert the RSS feed URL generated by this plugin in RSS feed URL section of MailChimp campaign generator as specified in above link<br>

Q7: How do I choose EDM templates?<br>
This version comes with couple of EDM templates. You can preview these templates by navigating to EDM Templates->Templates. <br>

Q8: How do I make my own EDM template?<br>
If you are a developer or HTML savvy, you can make your own EDM template. At present, EDM templates are compatible with Mailchimp only. If you see one of the template and preview it, you can see the section enclosed in 
{POST_BLOCK}
 //Everything that goes inside this block creates dynamic content for EDM template.
{/POST_BLOCK}

There are standard and special merge tags that you should use to alter the contents of your template that are as follows<br>

Standard Merge Tags<br>
{POST_TITLE} 		=> Title of post.<br>
{POST_LINK}			=> Details page link.<br>
{CONTENT_EXCERPT}	=> Summary of your post<br>
{POST_IMAGE}		=> Link of post image<br>
{POST_ID}			=> Post Id<br>

Special Merge Tags<br>
{wp2edmspcl-woo-product-price}		=>  Price of woocommerce product<br>

List of special merge tags to be uploaded soon.

Q9: Where do I get help if I have any issues?<br>
Please contact our support forum. We will try to resolve it as soon as possible

Q10: How do I receive and install EDM templates.<br>
Please download and install EDM templates by going through this [link](http://webavenue.com.au/wordpress-post-newsletter-campaign/)

== Screenshots ==

1. This is Add New Data Source-> Admin Panel. Here you can set up newsletter datasource with parameters such as Title, Description, Data source, Data type and Hero Post.
2. This is also part of Add New Data Source-> Admin Panel. Here you can alter various data source display settings such as Exclude posts, pages, Order By,  Sort order, Max no of items, Content Length and Date Format.
3. This is settings panel for Wp2Newsletter. You need to add MailChimp API key in order to generate Newsletter Campaign for Mailchimp. Also you can choose which data sources to be listed while adding data source.
4. This is final Generate Newsletter panel.
5. This is Visual preview of your Newsletter.
6. This is Visual preview of your EDM template.
7. This is HTML preview of your Newsletter.

== Changelog ==

= 1.0.0 =
This is the first version of plugin.
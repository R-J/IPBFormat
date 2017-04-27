<?php

$PluginInfo['IPBFormat'] = [
    'Name' => 'IPB Format',
    'Description' => 'Convert BBCode and HTML in posts formatted as "IPB".',
    'Version' => '0.0.1',
    'RequiredApplications' => ['Vanilla' => '>=2.3'],
    'MobileFriendly' => true,
    'Author' => 'Robin Jurinka',
    'AuthorUrl' => 'http://vanillaforums.org/profile/r_j',
    'License' => 'MIT'
];

Gdn::FactoryInstall('IPBFormatter', 'IPBFormatPlugin', __FILE__, Gdn::FactorySingleton);

class IPBFormatPlugin extends Gdn_Plugin {
    public function format($mixed) {
        $BBCodeFormatter = Gdn::factory('BBCodeFormatter');
        if (is_object($BBCodeFormatter)) {
            // Ignore html tags, since they will be treated later on.
            $BBCodeFormatter->nbbc()->setEscapeContent(false);
            // Don't handle line breaks.
            $BBCodeFormatter->nbbc()->setIgnoreNewlines(true);
            // Convert BBCode.
            $mixed = $BBCodeFormatter->format($mixed);
        }
        // Temporarily ignore line breaks.
        saveToConfig('Garden.Format.ReplaceNewlines', false, false);
        // Return converted HTML.
        return Gdn_Format::to($mixed, 'Html');
    }
}

<?php

class Bone_Validate_Url extends Zend_Validate_Abstract {
    
    const INVALID   = 'regexInvalid';
    const NOT_MATCH = 'urlNotValid';
    const ERROROUS  = 'regexErrorous';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID   => "Invalid type given. String, integer or float expected",
        self::NOT_MATCH => "'%value%' is not valid URL.",
        self::ERROROUS  => "There was an internal error while using the pattern '%pattern%'",
    );

    protected $tlds = 'ac|academy|ad|ae|aero|af|ag|agency|ai|al|am|an|ao|aq|ar|arpa|as|asia|at|au|aw|ax|az|ba|bargains|bb|bd|be|berlin|bf|bg|bh|bi|bike|biz|bj|blue|bm|bn|bo|boutique|br|bs|bt|build|builders|buzz|bv|bw|by|bz|ca|cab|camera|camp|cards|careers|cat|catering|cc|cd|center|ceo|cf|cg|ch|cheap|ci|ck|cl|cleaning|clothing|club|cm|cn|co|codes|coffee|com|community|company|computer|condos|construction|contractors|cool|coop|cr|cruises|cu|cv|cw|cx|cy|cz|dance|dating|de|democrat|diamonds|directory|dj|dk|dm|do|domains|dz|ec|edu|education|ee|eg|email|enterprises|equipment|er|es|estate|et|eu|events|expert|exposed|farm|fi|fj|fk|flights|florist|fm|fo|foundation|fr|futbol|ga|gallery|gb|gd|ge|gf|gg|gh|gi|gift|gl|glass|gm|gn|gov|gp|gq|gr|graphics|gs|gt|gu|guitars|guru|gw|gy|hk|hm|hn|holdings|holiday|house|hr|ht|hu|id|ie|il|im|immobilien|in|info|institute|int|international|io|iq|ir|is|it|je|jm|jo|jobs|jp|kaufen|ke|kg|kh|ki|kim|kitchen|kiwi|km|kn|kp|kr|kw|ky|kz|la|land|lb|lc|li|lighting|limo|link|lk|lr|ls|lt|lu|luxury|lv|ly|ma|maison|management|mango|marketing|mc|md|me|menu|mg|mh|mil|mk|ml|mm|mn|mo|mobi|moda|monash|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|nagoya|name|nc|ne|net|neustar|nf|ng|ni|ninja|nl|no|np|nr|nu|nz|om|onl|org|pa|partners|parts|pe|pf|pg|ph|photo|photography|photos|pics|pink|pk|pl|plumbing|pm|pn|post|pr|pro|productions|properties|ps|pt|pw|py|qa|qpon|re|recipes|red|rentals|repair|report|reviews|rich|ro|rs|ru|ruhr|rw|sa|sb|sc|sd|se|sexy|sg|sh|shiksha|shoes|si|singles|sj|sk|sl|sm|sn|so|social|solar|solutions|sr|st|su|support|sv|sx|sy|systems|sz|tattoo|tc|td|technology|tel|tf|tg|th|tienda|tips|tj|tk|tl|tm|tn|to|today|tokyo|tools|tp|tr|training|travel|tt|tv|tw|tz|ua|ug|uk|uno|us|uy|uz|va|vc|ve|ventures|vg|vi|viajes|villas|vision|vn|voting|voyage|vu|wang|watch|wed|wf|wien|wiki|works|ws|xn--3bst00m|xn--3ds443g|xn--3e0b707e|xn--45brj9c|xn--55qw42g|xn--55qx5d|xn--6frz82g|xn--6qq986b3xl|xn--80ao21a|xn--80asehdb|xn--80aswg|xn--90a3ac|xn--clchc0ea0b2g2a9gcd|xn--fiq228c5hs|xn--fiq64b|xn--fiqs8s|xn--fiqz9s|xn--fpcrj9c3d|xn--fzc2c9e2c|xn--gecrj9c|xn--h2brj9c|xn--io0a7i|xn--j1amh|xn--j6w193g|xn--kprw13d|xn--kpry57d|xn--l1acc|xn--lgbbat1ad8j|xn--mgb9awbf|xn--mgba3a4f16a|xn--mgbaam7a8h|xn--mgbab2bd|xn--mgbayh7gpa|xn--mgbbh1a71e|xn--mgbc0a9azcg|xn--mgberp4a5d4ar|xn--mgbx4cd0ab|xn--ngbc5azd|xn--o3cw4h|xn--ogbpf8fl|xn--p1ai|xn--pgbs0dh|xn--q9jyb4c|xn--s9brj9c|xn--unup4y|xn--wgbh1c|xn--wgbl6a|xn--xkc2al3hye2a|xn--xkc2dl3a5ee0h|xn--yfro4i67o|xn--ygbi2ammx|xn--zfr164b|xxx|xyz|ye|yt|za|zm|zone|zw';
    
    /**
     * @var array
     */
    protected $_messageVariables = array(
        'pattern' => '_pattern'
    );

    /**
     * Regular expression pattern
     *
     * @var string
     */
    protected $_pattern;
    
    public function __construct() {
        self::setPattern();
    }
    
    /**
     * Returns the pattern option
     *
     * @return string
     */
    public function getPattern(){
        return $this->_pattern;
    }
    
    /**
     * Sets the pattern
     *
     * @throws Zend_Validate_Exception if there is a fatal error in pattern matching
     * @return Zend_Validate_Regex Provides a fluent interface
     */
    private function setPattern() {
        
        $tlds = $this->tlds;
        
        $protocol = '((https?):\/{2})?';
        $domain = '((([a-z0-9]+(\-)+?[a-z0-9-]+[^\-])|([a-z0-9]+))\.)+('.$tlds.')';
        $port = '(:[0-9]+)?';
        $page = '(\/([~0-9a-zA-Z\#\+\%@\.\/_-]+)?)?';
        $get_vars = '(\?[0-9a-zA-Z\+\%@\/&\[\];=_-]+)?';
                
        
        $pattern = '/^'.$protocol.'('.$domain.$port.'('.$page.$get_vars.')?)\b$/iu';
        
        $this->_pattern = (string) $pattern;
        $status         = @preg_match($this->_pattern, "Test");

        if (false === $status) {
            require_once 'Zend/Validate/Exception.php';
            throw new Zend_Validate_Exception("Internal error while using the pattern '$this->_pattern'");
        }

        return $this;
    }

    public function isValid($value) {
        if (!is_string($value) && !is_int($value) && !is_float($value)) {
            $this->_error(self::INVALID);
            return false;
        }
        
        // We want ot work with non-encoded url
        if(urlencode(urldecode($value)) === $value){
            // $value is urlencoded
            $this->_setValue(urldecode($value));
            $url = urldecode($value);
        } else {
            $this->_setValue($value);
            $url = $value;
        }
                
        $url_minus_protocol = preg_match('/^(https?:\/\/)/', $url) ? preg_replace('/^(https?:\/\/)/', '', $url) : $url;
        $maxPos = strpos($url_minus_protocol, '/');
        
        if($maxPos === false){
            $host = $url_minus_protocol;
        } else {
            $host = substr($url_minus_protocol, 0, $maxPos);
            $pageStuff = substr($url_minus_protocol, $maxPos);
        }
        
        // converting the host to IDN*
        $idn_host = idn_to_ascii($host);
        if(!$idn_host){
            $this->_error(self::NOT_MATCH);
            return false;
        }
        
        // Maximum lenght for the domain name is 63 and for whole host name 255
        $domain_parts = array_reverse( explode('.', $host) );
        if(mb_strlen($domain_parts[1], 'utf-8') > 63 || mb_strlen($host, 'utf-8') > 255){
            $this->_error(self::NOT_MATCH);
            return false;
        }        
        
        // The host is (can be) encoded to IDNA without errors.
        // The hostname length looks OK.
        // Now we will perform full URL check.
        if(isset($pageStuff) && strlen($pageStuff) > 1){
            // Our regex-pattern works only with ascii characters, so we urlencode all stuff after first .tld/
            $encodedPageStuff = str_replace(array("%20", "%2F"),array("+", "/"), urlencode(urldecode($pageStuff)));
            $idn_url = str_replace($host, $idn_host, str_replace($pageStuff, $encodedPageStuff, $url));
        } else {
            $idn_url = str_replace($host, $idn_host, $url);
        }
        
        $status = @preg_match($this->_pattern, $idn_url);
        
        if (false === $status) {
            $this->_error(self::ERROROUS);
            return false;
        }

        if (!$status) {
            $this->_error(self::NOT_MATCH);
            return false;
        }
        
        return true;
    }
}

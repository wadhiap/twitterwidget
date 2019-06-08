<?php 
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use TwitterWebsiteWidget\TwitterWidget;
use TwitterWebsiteWidget\TwitterView;
use TwitterWebsiteWidget\TwitterConnectorAuthOnlyOAuth2Curl;

final class TwitterTest extends TestCase
{
    public function testCanInstanceOfClass(): void
    {
        $api_connector = new TwitterConnectorAuthOnlyOAuth2Curl('123','456');
        $this->assertInstanceOf(TwitterConnectorAuthOnlyOAuth2Curl::class,$api_connector);
    }
    
    public function testErrorResponseFormating(): void
    {
        $fakeobject = array((object) array('message'=>'Some error msg', 'code'=>'123'));
        $fakeobject = (object)array('errors' => $fakeobject);
     
        $twitter = new TwitterWidget(new TwitterConnectorAuthOnlyOAuth2Curl('123','456'));
        $twitter->data = $fakeobject;
        $view = new TwitterView('sometemple.php',$twitter);
        $output = $view->render();
        $this->assertEquals($output,'Error: Some error msg(123)');
    }
}

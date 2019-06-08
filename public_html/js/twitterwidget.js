var fontsize;
var color_array = ["#ebf5fb", "#f9ebea", "#f4ecf7", "#fef9e7", "#fae5d3", "#e8f6f3" ];
    
function refreshTweets(){
    $('#twitter_app_msg').text('Refreshing tweets..');
    $.get( "get.php", function( data ) {
        $( "#twitter_app_tweets" ).html( data );
        $('#twitter_app_msg').text('Tweets loaded!').fadeOut(2000,function(){
            $('#twitter_app_msg').show().html('&nbsp;');
        });
        $('.tweet_wrapper').css('font-size',fontsize);
        setTimeout(refreshTweets, 30000); 
    });
}

$(document).ready(function(){

    // add placeholders
    var tools_html = '<div id="tweet_tools_wrapper">' +
                        '<div id="tweet_tools_font_wrapper">' +
                            '<button id="tweet_tools_font_up_button">+</button>' +
                                'Font size' +
                            '<button id="tweet_tools_font_down_button">-</button>' +
                        '</div>' +
                        '<div id="tweet_tools_bg_wrapper">' +
                            '<button id="tweet_tools_bg_button" >Change Background color</button>' +
                        '</div>' +
                      '</div>';
    $('#twitter_wrapper').append(tools_html);
    $('#twitter_wrapper').append('<div id="twitter_app_msg"></div>');
    $('#twitter_wrapper').append('<div id="twitter_app_tweets"></div>');

    // get tweets on first load...
    refreshTweets();

    // Begin tools functionality...

    // font change..
    $('#tweet_tools_font_up_button').click(function(){
        fontsize = $('.tweet_wrapper').css('font-size');
        fontsize = parseInt(fontsize)+1;
        $('.tweet_wrapper').css('font-size',fontsize);
    });
    
    $('#tweet_tools_font_down_button').click(function(){
        fontsize = $('.tweet_wrapper').css('font-size');
        fontsize = parseInt(fontsize)-1;
        $('.tweet_wrapper').css('font-size',fontsize);
    });
    
    // background-color change..
    $('#tweet_tools_bg_button').click(function(){
        let random = Math.floor(Math.random() * color_array.length); 			
        $('#twitter_wrapper').css('background-color',color_array[random]);
    });
});


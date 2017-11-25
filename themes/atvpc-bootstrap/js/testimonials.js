var testimonials = [ 
    ["Product was exactly as described and shipping was fast. Totally satisfied.", "James"],
    ["Great price, good packaging, and very fast shipping. Product arrived exactly as descriped. Thank you.", "Daniel"],
    ["Received quickly! Thanks", "Rodney"],
    ["Item worked perfect", "Mike"],
    ["Great quality and fit", "Jared"],
    ["No hassel transaction. Got my belt when promised. My machine is up and running again", "Marty"],
    ["Thank you for an excellent product, and service", "Marty"],
    ["Smooth transaction and prompt shipping! Thanks", "Eric"],
    ["Awesome very fast shipping will use every time", "eBay User"],
    ["Everything I needed to get the job done. Fast shipping!", "eBay User"],
    ["Amazing seller! Paid for product last night and it showed up today!", "eBay User"],
    ["Vendor worked very well with my special shipping needs. Thanks a lot!!!", "eBay User"],
    ["Item was received as promised, and in good condition. Thank you!", "eBay User"],
    ["Excellent seller. More than satisfied. Will urge all my friends to use them also.", "eBay User"],
    ["Quick shipping of great product very appreciated! Thanks so much!", "eBay User"],
    ["The fact that I will return to buy more from atvpartsconnection says it all.", "eBay User"],
    ["Rocket fast shipping and an exceptional product, definitely would deal with again.", "eBay User"],
    ["Great aftermarket replacement and price. Shipped quickly.", "eBay User"],
    ["The part arrived quickly, well packaged, and fit the ATV perfectly.", "eBay User"],
    ["Awesome!!! Thanks for great product at a great price!!", "eBay User"],
    ["Great seller! Ordered wrong, returned and replaced. No hassle!!!!", "eBay User"],
    ["Fast Shipping. Good Packaging. Good Experience", "eBay User"],
    ["This part is awesome. I will be buying another for the other side soon.", "eBay User"],
    ["An excellent vendor. This is my third item purchased from them.", "eBay User"],
    ["Excellent ebay seller, fast shipping, low prices, I will continue to buy from them.", "eBay User"],
    ["Fast shipping, Great communication, will buy from again! AWESOME SELLER.", "eBay User"],
    ["The best price. Quality goods.", "eBay User"],
    ["Part arrived in good time and was as expected. Will buy from them again.", "eBay User"],
    ["Easy transaction and a perfect replacement for a good price.", "eBay User"],
    ["Shipping was faster than expected and I\"m pleased with the product", "eBay User"],
    ["Right on the money... will do business with them again...", "eBay User"],
    ["I\'m very satisfyied with my purchase. Shipping was very prompt as well. Thanks", "eBay User"],
    ["Better than stock. Great customer service", "eBay User"],
    ["At the house before I knew it. Great quality product", "eBay User"],
    ["Polaris drive shafts arrived. Fantastic service, thank you", "eBay User"],
    ["The parts are a direct fit and only took 20 mins to put in", "eBay User"],
    ["perfect fit, good quality rubber, fast shipping and good price", "eBay User"],
    ["Great Product! Got ATV up and running! Thanks", "eBay User"],
    ["Great item. Great buyer. Will definitely get my axles here again!!!", "eBay User"],
    ["Excellent seller, prompt delivery and part worked great on our Yamaha", "eBay User"],
    ["I would recommend this product and complement the seller on the speedy delivery", "eBay User"],
    ["Extremely happy customer. Excellent packaging and order details spot on!", "eBay User"],
    ["Bought two kits. Parts were spot-on! Easy transaction, fast shipping.", "eBay User"],
    ["Solid construction. Perfect fit.", "eBay User"],
    ["fast shipment and the U-joints where a perfect fit, thanks.", "eBay User"],
    ["Outstanding! Quick sales and quick receipt of items. The parts are correct.", "eBay User"],
    ["Excellent service, answered all questions, fast delivery, recommended!!!", "eBay User"],
    ["Arrived sooner than expected. Great seller!", "eBay User"],
    ["Excellent Customer support, would definitely purchase from them again.", "eBay User"],
    ["Fast shipping arrived before estimated delivery date.", "eBay User"],
    ["Product was delivered very fast and is better than factory at a way less cost.", "eBay User"]
];

function newTestimonial() {
    var testimonial = testimonials[Math.floor(Math.random() * testimonials.length)];

    var quote =  "<span class='testimonial-quote'>" + testimonial[0] + "</span>";
    var author = "<span class='testimonial-author pull-right'>" + testimonial[1] + "</span>";

    return quote + author;
}

function aniTestimonial() {
    $( "#testimonials" ).fadeOut( "slow", function() {
        $( "#testimonials" ).html( newTestimonial ).fadeIn( "slow" );
    });
}

$( document ).ready(function() {

    // Make sure testimonials exists on the page before creating timers
    if( $( "#testimonials" ).length ) {

        // Populate the testimonial on first page load
        $( "#testimonials" ).html( newTestimonial() );

        // animate new testimonials every 5 seconds
        var testimonialTimer = setInterval(aniTestimonial, 5000);
    }
});

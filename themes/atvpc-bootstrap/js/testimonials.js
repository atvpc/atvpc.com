var testimonials = [
  "Product was exactly as described and shipping was fast. Totally satisfied",
  "Great price, good packaging, and very fast shipping. Product arrived exactly as descriped. Thank you",
  "Received quickly! Thanks",
  "Item worked perfect",
  "Great quality and fit",
  "No hassel transaction. Got my belt when promised. My machine is up and running again",
  "Thank you for an excellent product, and service",
  "Smooth transaction and prompt shipping! Thanks",
  "Awesome very fast shipping will use every time",
  "Everything I needed to get the job done. Fast shipping!",
  "Amazing seller! Paid for product last night and it showed up today!",
  "Vendor worked very well with my special shipping needs. Thanks a lot!!!",
  "Item was received as promised, and in good condition. Thank you!",
  "Excellent seller. More than satisfied. Will urge all my friends to use them also",
  "Quick shipping of great product very appreciated! Thanks so much!",
  "The fact that I will return to buy more from atvpartsconnection says it all",
  "Rocket fast shipping and an exceptional product, definitely would deal with again",
  "Great aftermarket replacement and price. Shipped quickly",
  "The part arrived quickly, well packaged, and fit the ATV perfectly",
  "Awesome!!! Thanks for great product at a great price!!",
  "Great seller! Ordered wrong, returned and replaced. No hassle!!!!",
  "Fast Shipping. Good Packaging. Good Experience",
  "This part is awesome. I will be buying another for the other side soon",
  "An excellent vendor. This is my third item purchased from them",
  "Excellent ebay seller, fast shipping, low prices, I will continue to buy from them",
  "Fast shipping, Great communication, will buy from again! AWESOME SELLER",
  "The best price. Quality goods",
  "Part arrived in good time and was as expected. Will buy from them again",
  "Easy transaction and a perfect replacement for a good price",
  "Shipping was faster than expected and I\"m pleased with the product",
  "Right on the money... will do business with them again...",
  "I\'m very satisfyied with my purchase. Shipping was very prompt as well. Thanks",
  "Better than stock. Great customer service",
  "At the house before I knew it. Great quality product",
  "Polaris drive shafts arrived. Fantastic service, thank you",
  "The parts are a direct fit and only took 20 mins to put in",
  "Perfect fit, good quality rubber, fast shipping, and good price",
  "Great Product! Got ATV up and running! Thanks",
  "Great item. Great buyer. Will definitely get my axles here again!!!",
  "Excellent seller, prompt delivery and part worked great on our Yamaha",
  "I would recommend this product and complement the seller on the speedy delivery",
  "Extremely happy customer. Excellent packaging and order details spot on!",
  "Bought two kits. Parts were spot-on! Easy transaction, fast shipping",
  "Solid construction. Perfect fit",
  "fast shipment and the U-joints where a perfect fit, thanks",
  "Outstanding! Quick sales and quick receipt of items. The parts are correct",
  "Excellent service, answered all questions, fast delivery, recommended!!!",
  "Arrived sooner than expected. Great seller!",
  "Excellent Customer support, would definitely purchase from them again",
  "Fast shipping arrived before estimated delivery date",
  "Product was delivered very fast and is better than factory at a way less cost",
  "As advertised, no surprises. Would purchase from again in future for sure. Thx",
  "Super fast can't go wrong with this seller",
  "Excellent product, very well priced, and fast shipping",
  "Amazing quality, machine rides like a dream, best $80 I've spent!!!!!!",
  "Packaged very well and fast shipping thank you",
  "Lightning fast shipping and a great deal. Will buy from again!",
  "Arrived ahead of schedule and was a perfect fit",
  "Great Ebayer! This Iraq War Veteran enjoyed doing business with them! HOOAH!!!",
  "Very professional and courteous company. I will order from them again and again",
  "Went in tight, but works fine. No issues AA++",
  "Hassle free delivery, very accomidating, great products, great communication",
  "Great product... exactly as described w/ fast delivery! Will buy again... Thx!"
  "Got it, thank you. Can't wait to install. FAST SHIPPING",
  "Absolutely blazing fast delivery, Great price! Awesome Ebay seller!! A+",
  "Very fast shipping. Nice bearings, can’t wait to install",
  "Fast shipping to Canada, good quality, would buy again, thanks. A+++++++",
  "Fit perfect, high quality and matches OEM",
  "Fast shipping to Germany. Good Salesman. Gladly purchase again",
  "Placed the order on Sunday got it in on wednesday.... Good service!!",
  "Thank you for making my return process reasonably smooth!"
];

function newTestimonial() {
  var testimonial = testimonials[Math.floor(Math.random() * testimonials.length)];
  return "<span class='testimonial'>" + testimonial + "</span>";
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

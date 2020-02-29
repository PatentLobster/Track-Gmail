


function generateImageToken(e) {
  var reciverAddr = e.draftMetadata.toRecipients;
  var k = 'k';
  var url = 'https://example.com/index.php?somewhatsecurelol=lol&title='+ k +'&addr=' + reciverAddr;
  // Make a GET request and log the returned content.
  var response = UrlFetchApp.fetch(url);
  return response;
}


function getImageUrl(e) { 
   //var reciverAddr = e.draftMetadata.toRecipients;
//   var reciverAddr = e.draftMetadata;
//   var subject = message.getSubject();
//   return reciverAddr;
     return 'https://example.com/index.php?signature=' + generateImageToken(e);
}


function getImageToken(id) {
  // Make a GET request and log the returned content.
  var url = 'https://example.com/index.php?signature=' + id;
  //var response = UrlFetchApp.fetch(url);
  return url;
}



    /**
     * Compose trigger function that fires when the compose action is
     * selected. Builds and returns a compose UI for inserting images.
     *
     * @param {event} e The compose trigger event object. Not used in
     *         this example.
     * @return {Card[]}
     */
    function getInsertImageComposeUI(e) {
      return [buildImageComposeCard(e)];
    }

    /**
     * Build a card to display images from a third-party source.
     *
     * @return {Card}
     */
    function buildImageComposeCard(e) {
      // Get a list of image URLs to display in the UI.
      // This function is not shown in this example.
      //var imageUrls = getImageUrls();
      var imageUrls =  getImageToken(generateImageToken(e));
      var test =  getImageToken(generateImageToken(e));
      var card = CardService.newCardBuilder();
      var cardSection = CardService.newCardSection().setHeader('My Images');

      cardSection.addWidget(CardService.newImage().setImageUrl(imageUrls).setOnClickAction(CardService.newAction().setFunctionName('applyInsertImageAction').setParameters({'url' : test})));
      return card.addSection(cardSection).build();
    }

    /**
     * Adds an image to the current draft email when the image is clicked
     * in the compose UI. The image is inserted at the current cursor
     * location. If any content of the email draft is currently selected,
     * it is deleted and replaced with the image.
     *
     * Note: this is not the compose action, but rather an action taken
     * when the user interacts with the compose action's corresponding UI.
     *
     * @param {event} e The incoming event object.
     * @return {UpdateDraftActionResponse}
     */
    function applyInsertImageAction(e) {
      var imageUrl = e.parameters.url;
      var imageHtmlContent = '<img style=\"display: block\" src=\"'
           + imageUrl + '\"/> ';
      var response = CardService.newUpdateDraftActionResponseBuilder()
          .setUpdateDraftBodyAction(CardService.newUpdateDraftBodyAction()
              .addUpdateContent(
                  imageHtmlContent,
                  CardService.ContentType.MUTABLE_HTML)
              .setUpdateType(
                  CardService.UpdateDraftBodyType.IN_PLACE_INSERT))
          .build();
      return response;
    }

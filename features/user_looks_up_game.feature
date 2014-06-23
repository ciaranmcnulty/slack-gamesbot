Feature: In order to share game details with others
    As a channel participant
    I should be able to look up games

    Scenario: Searching for game by keyword
      When I type the text "boardgame Agricola" in the "#board-games" channel
      Then The username "gamebot" should reply
       And The message should be "Agricola: http://boardgamegeek.com/game/31260"

    Scenario: Searching for game by keyword
      When I type the text "boardgame SomethingMadeUp" in the "#board-games" channel
      Then The username "gamebot" should reply
       And The message should be "Sorry, I don't know that game"
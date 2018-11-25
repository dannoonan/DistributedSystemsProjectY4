/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package controllers;

import daos.GameDao;
import guiViews.GameScreen;
import models.Game;
import models.GameThread;

/**
 *
 * @author windows
 */
public class GameController {
    
    Game game;
    GameScreen gameScreen;
    GameDao gameDao;
    
    public GameController(Game game, GameScreen gameScreen){
        this.gameScreen = gameScreen;
        this.game = game;  
        this.gameScreen.AddListener(this);
        gameDao = new GameDao(game.getUserId(),game.getGameId());
    }
    
    
    /**
     * Takes a string corresponding to the coordinates of a button pressed in the 
     * gameScreen. Depending on the string passed in, two int values specifying the coordinates
     * are passed to a method that specifies the action to be taken
     * @param buttonName 
     */
    public void buttonPressed(String buttonName){
         switch(buttonName){
             case "00":
                 buttonAction(0,0); 
                 break;
             case "01":
                 buttonAction(0,1); 
                 break;
             case "02":
                 buttonAction(0,2); 
                 break;
             case "10":
                 buttonAction(1,0); 
                 break;
             case "11":
                 buttonAction(1,1); 
                 break;
             case "12":
                 buttonAction(1,2); 
                 break;
             case "20":
                 buttonAction(2,0); 
                 break;
             case "21":
                 buttonAction(2,1); 
                 break;
             case "22":
                 buttonAction(2,2); 
                 break;
                 
         }
    }
    /**
     * 
     * @param x
     * @param y 
     */
    public void buttonAction(int x, int y){
        //pollDb();
        //If the game isn't over, and the game has started, respond to input from buttons
        if(game.getGameOver()==false&&game.getGameInProgress()==true){
            String result = gameDao.checkSquare(x, y, game.getGameId());
            System.out.println("result is: "+result);
            System.out.println("turnPlauable is "+game.getTurnPlayable());
            //If it is the player's turn, allow the player to make a move
            if(game.getTurnPlayable()){
               if("0".equals(result)){
                    result = gameDao.takeSquare(x, y, game.getUserId(), game.getGameId());

                    if("1".equals(result)) {  
                        gameScreen.setBoardLabels(x, y, game.getPlayerSymbol());
                        waitTurn();    
                    }
               }else if("1".equals(result)){
                    gameScreen.setWarnLabel("Square already taken");
               }else{
                     gameScreen.setWarnLabel(result);
               } 
            }else{
                gameScreen.setWarnLabel("NOT TURN!");
            } 
        }
    }
   /**
    *Updates the board using the most recent board configuration pulled by the gameDao from
    * the API. The string sent back from the DAO is split, the player who made each move
    * is ascertained, and the appropriate symbol is placed in each part of the board
    * according to the moves
    */ 
    public void setBoardView(){
        //pollDb();
        gameScreen.setWarnLabel(".");
        if(game.getGameOver()==false&&game.getGameInProgress()==true){
            if(!game.getBoard().equals("ERROR-NOMOVES")){
                String[] moves = gameDao.getBoard().split("\\s*\n\\s*");
                for(int i=0; i<moves.length;i++){
                    String [] movesDetails = moves[i].split("\\s*,\\s*");
                    int playerId = Integer.parseInt(movesDetails[0]);
                    String x = movesDetails[1];
                    String y = movesDetails[2];
                    //tempSymbol will correspond to the symbol of whichever player made the move
                    String tempSymbol = "";

                    if(playerId==game.getUserId()){
                        tempSymbol=game.getPlayerSymbol();
                    }else{
                        tempSymbol=game.getOpponentSymbol();
                    }
                    //
                    if(x.equals("0")&&y.equals("0")){
                        
                        gameScreen.setBoardLabels(0,0, tempSymbol);

                    }else if(x.equals("0")&&y.equals("1")){
                        gameScreen.setBoardLabels(0,1, tempSymbol);
                    }
                    else if(x.equals("0")&&y.equals("2")){
                        gameScreen.setBoardLabels(0,2, tempSymbol);
                    }
                    else if(x.equals("1")&&y.equals("0")){
                        gameScreen.setBoardLabels(1,0, tempSymbol);
                    }
                    else if(x.equals("1")&&y.equals("1")){
                        gameScreen.setBoardLabels(1,1, tempSymbol);
                    }
                    else if(x.equals("1")&&y.equals("2")){
                        gameScreen.setBoardLabels(1,2, tempSymbol);
                    }
                    else if(x.equals("2")&&y.equals("0")){
                        gameScreen.setBoardLabels(2,0, tempSymbol);
                    }
                    else if(x.equals("2")&&y.equals("1")){
                        gameScreen.setBoardLabels(2,1, tempSymbol);
                    }
                    else if(x.equals("2")&&y.equals("2")){
                        gameScreen.setBoardLabels(2,2, tempSymbol);
                    }

                }
            }
        }
    }
    /**
     * Mehtod called by the gameScreen when the update button is pressed. Method checks
     * that the game is running,  calls the method that polls the database to make sure that the game's board is
     * up to date, and calls the method to set the board view. The checkWin method is called next, to check 
     * if either player has won. If so the winner is declared on the gameScreen, and the game is no longer
     * playable
     */
    public void updateBoardView(){
        if(game.getGameInProgress()==true){
            pollDb();
            setBoardView();
            if(!game.getBoard().equals("ERROR-NOMOVES")){
                checkWin();
                if(game.getGameOver()==true){
                    game.setTurnPlayable(false);
                    announceWinner();
                }
            }
        }
    }
    /**
     * Calls the method in the Game class, which uses the GameDao to
     * poll the database until there is a change that indicates the second
     * player has joined the game
     */
    public void gameStarted(){
        //gameScreen.setAnnounceLabel("Waiting for game to start");
        game.gameStarted();
        //gameScreen.setAnnounceLabel(".");
        //gameScreen.setVisible(true);
    }
    /**
     * Creates a thread to check the database to see
     * if the turn is the player's or opponent's
     */
    public void pollDb(){
       GameThread pollThread; 
       
       pollThread = new GameThread( "PollThread", gameDao, game );
       pollThread.start();
       
       try{                 
           pollThread.join();

        }catch ( Exception e) {
           System.out.println("Interrupted");
        }
        
   }
    /**
     * Checks if game is won. If it is, then the 
     * waitForTurn method called next will return a value
     * indicating this is the case. The winner is then announced
     */
    public void waitTurn(){  
       checkWin();
       if(waitForTurn()==1){
          announceWinner();
          
       }
    }
   /**
    * Retrieves the name of the winner - or the fact of a draw - as
    * a string, then calls a method in gameScreen to announce the winner
    * on the announceLabel
    */ 
    public void announceWinner(){
        if(!game.getWinner().equals("Draw")) {
               gameScreen.setAnnounceLabel(game.getWinner()+ " wins");
          }else{
              gameScreen.setAnnounceLabel(game.getWinner());
          }
    }
    
    public int waitForTurn(){       
       GameThread waitThread;       
       waitThread = new GameThread( "WaitThread", gameDao, game );
       waitThread.start();
       if(game.getGameOver()==true){
           game.setTurnPlayable(false);
           return 1;
       }
       
        try{                 
            waitThread.join();

        }catch ( Exception e) {
            System.out.println("Interrupted");
        }
      
       System.out.println("in method waitforturn");
       return 0;
   }
    /**
     * Uses the game DAO to check if the game has been won.
     * If so, the method sets the winner String in game,
     * sets the gameOver boolean in game to true, and 
     * tells the DAO to update the database accordingly.
     */
    public void checkWin(){
       String resultString = gameDao.checkWin();
       
       if(resultString.equals("1")){
           game.setWinner("Player 1");
           game.setGameOver(true);
           gameDao.setGameState(1);
           setBoardView();
       }else if(resultString.equals("2")){
           game.setWinner("Player 2");
           game.setGameOver(true);
           gameDao.setGameState(2); 
           setBoardView();
       }else if(resultString.equals("3")){
           game.setWinner("Draw");
           game.setGameOver(true);
           gameDao.setGameState(3);
           setBoardView();
       }else{
           game.setGameOver(false);
           setBoardView();
       }
   }
    
}

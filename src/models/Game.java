/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package models;

import daos.GameDao;
import java.util.List;
import java.util.ArrayList;

/**
 *
 * @author windows
 */
public class Game  {

     static GameDao gameDao;
     static int playerNum;
     static int userId;
     static int gameId;
     static String boardState;
     static boolean gameInProgress;
     static boolean turnPlayable;
     static String playerSymbol;
     static String opponentSymbol;
     static Game game;
     static boolean gameOver;
     static String winner;
     
   
    
   public Game(int uid, int gid, int playerNum){
       this.userId = uid;
       this.gameId = gid;
       this.playerNum = playerNum;
       gameInProgress = true;
       turnPlayable = false;
       if(playerNum==1){
            turnPlayable = true;
       }
       
       if(playerNum==1){
           playerSymbol ="__X__";
           opponentSymbol = "__O__";
       }else{
           playerSymbol ="__O__";
           opponentSymbol = "__X__";
       }
       gameDao = new GameDao(userId, gameId);
       boardState = gameDao.getBoard();
       this.game = this;
       gameOver = false;
       winner = "";
       //System.out.println("in game constructor");
       //System.out.println("turnplayable =="+turnPlayable);     
       //pollDb();
    
   }
   
   public int getGameId(){
       return gameId;
   }
   public int getUserId(){
       return userId;
   }
   public boolean getTurnPlayable(){
       return turnPlayable;
   }
   public void setTurnPlayable(boolean turnPlayable){
       this.turnPlayable = turnPlayable;
   }
   public String getPlayerSymbol(){
       return playerSymbol;
   }
   public void setPlayerSymbol(String playerSymbol){
       this.playerSymbol = playerSymbol;
   }
   public String getOpponentSymbol(){
       return opponentSymbol;
   }
   public void setOpponentSymbol(String playerSymbol){
       this.opponentSymbol = opponentSymbol;
   }
   public String getBoard(){
       //System.out.println(boardState);
       return boardState;
        
   }
   public void setBoard(){
       boardState = gameDao.getBoard();
   }    
   public void setBoard2(String bstate){
       boardState = bstate;
       //System.out.println(boardState+ " is the changed board in method");
   }    
   public String getWinner(){
        return winner;
   }
   public void setWinner(String winner){
       this.winner = winner;
   }
   public int getPlayerNum(){     
       return playerNum;
   }
   public boolean getGameInProgress(){
       return gameInProgress;
   }
   public void setGameInProgress(boolean gameInProgress){
       this.gameInProgress = gameInProgress;
   }
   public boolean getGameOver(){
       return gameOver;
   }
   public void setGameOver(boolean gameOver){
       this.gameOver = gameOver;
   }
   public String getDaoBoard(){
       return gameDao.getBoard();
   }
   
   
   public boolean checkWin(){
       String resultString = gameDao.checkWin();
       
       if(resultString.equals("1")){
           winner ="Player 1";
           gameOver = true;
           gameDao.setGameState(1);
       }else if(resultString.equals("2")){
            winner = "Player 2";
            gameOver = true;
            gameDao.setGameState(2);
       }else if(resultString.equals("3")){
            winner = "Draw";
            gameOver = true;
            gameDao.setGameState(3);
       }else{
           gameOver = false;
       }
       
       return gameOver;
   }
   
      public int waitForTurn(){
  
       
       GameThread waitThread; 
       
       waitThread = new GameThread( "WaitThread", gameDao, game );
       waitThread.start();
       if(checkWin()==true){
           turnPlayable =false;
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
 
   public boolean gameStarted(){
       boolean retBool =false;
       
       if(playerNum ==2){
           retBool = true;
       }
        //System.out.println("in gamestart function");
       while(retBool == false){ 
            if(gameDao.getGameState().equals("-1")){
                retBool =false;
                //System.out.println("in gamestart function -- false");
            }else if(gameDao.getGameState().equals("0")){
                retBool =true;
                //System.out.println("in gamestart function ---true");
            }
       }
       return retBool;
   }
   
   
}

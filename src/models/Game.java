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
     private List<Observer> observers ;
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
       gameDao = new GameDao(userId, gameId);
       boardState = gameDao.getBoard();
       this.game = this;
       observers = new ArrayList<Observer>();
       gameOver = false;
       winner = "";
       System.out.println("in game constructor");
       System.out.println("turnplayable =="+turnPlayable);
      // startThreads();
      //notifyAllObservers();
      pollDb();
       
         
        
   }
   
   public boolean getTurnPlayable(){
       return turnPlayable;
   }
   public String getBoard(){
       return boardState;
   }
   public void setBoard(){
       boardState = gameDao.getBoard();
   }
   public void setTurnPlayable(boolean turnPlayable){
       this.turnPlayable = turnPlayable;  
       notifyAllObservers();
   }
   
   public void attach(Observer observer){
       observers.add(observer);	
   }
   public void notifyAllObservers(){
      for (Observer observer : observers) {
         observer.update();
      }
   } 
   
   public boolean checkWin(){
       String resultString = gameDao.checkWin();
       
       if(resultString.equals("1")){
           winner = "Player 1";
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
   
   public String getWinner(){
        return winner;
   }
   
   public int getPlayerNum(){
       
       return playerNum;
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
   
 /*  public void startThreads(){
       System.out.println("in game main ");
    
        System.out.println("in game main 1");
        GameThread playThread ;
        GameThread pollThread;
        
        
        
             
          
       
          
                  
       
        System.out.println(playerNum + " is the playernum");
         for(int i=0; i<9; i++){
            if(turnPlayable){
              try{      
                  playThread = new GameThread( "PlayThread", gameDao, game );           
                  playThread.start();            
                  playThread.join();
                 
              }catch ( Exception e) {
                 System.out.println("Interrupted");
              }
            }else{
                 try{      
                   pollThread = new GameThread( "PollThread", gameDao, game );
                  pollThread.start();            
                  pollThread.join();
                 

              }catch ( Exception e) {
                 System.out.println("Interrupted");
              }
                
            }
         
         }
        
   }*/
    
    public static void main(String[] args){
     
    }
    
}

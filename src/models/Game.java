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
       System.out.println("in game constructor");
       System.out.println("turnplayable =="+turnPlayable);
      // startThreads();
      notifyAllObservers();
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

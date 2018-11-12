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
       gameDao = new GameDao(userId, gameId);
       this.game = this;
       observers = new ArrayList<Observer>();
       System.out.println("in game constructor");
       
         
        
   }
   
   public boolean getTurnPlayable(){
       return turnPlayable;
   }
   public void setTurnPlayable(boolean turnPlayable){
       this.turnPlayable = turnPlayable;    
   }
   
   public void attach(Observer observer){
       observers.add(observer);	
   }
   public void notifyAllObservers(){
      for (Observer observer : observers) {
         observer.update();
      }
   } 
    
    public static void main(String[] args){
     System.out.println("in game main ");
     while(gameInProgress){ 
         System.out.println("in game main 1");
        GameThread pollThread = new GameThread( "PollThread", gameDao, game );
        GameThread playThread = new GameThread( "PlayThread", gameDao, game );

         pollThread.start();
         playThread.start();
         if(playerNum==1){
            try{
                playThread.join();
                pollThread.join();
                

            }catch ( Exception e) {
               System.out.println("Interrupted");
            }
         } else{
             try{
               pollThread.join(); 
               playThread.join();
                
                

            }catch ( Exception e) {
               System.out.println("Interrupted");
            }
             
         }  
     }
        
    }
    
}

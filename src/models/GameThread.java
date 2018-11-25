/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package models;

import daos.GameDao;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author windows
 */
public class GameThread extends Thread {
   private Thread t;
   private String threadName;
   GameDao gameDao;
   Game game;
    
   
   public GameThread(String name, GameDao gDao, Game game){
       this.gameDao = gDao;
       this.threadName = name;
       this.game = game;
       System.out.println("Creating " +  threadName );
   }
    
    @Override
    public void run() {
        synchronized(gameDao){         
               try{
                String boardState1 = game.getBoard();
                //String boardState2 = gameDao.getBoard();
                String boardState2 = gameDao.getBoard();

                System.out.println("one poll");
                System.out.println(game.getTurnPlayable());
                System.out.println(boardState1+ " IS  BSTATE 1");
                System.out.println(boardState2+ " IS  BSTATE 2");
                
                if(boardState1.equals(boardState2)){
                    System.out.println("EQUALS");
                }
                
                if(!game.getTurnPlayable()){
                    if(!boardState1.equals(boardState2)){ 
                        System.out.println("in play true");
                        game.setTurnPlayable(true);
                        //game.setBoard();
                        game.setBoard2(boardState2);
               
                    }else if(boardState1.equals(boardState2)){
                        System.out.println("in play false");
                        System.out.println(this.threadName);
                        game.setTurnPlayable(false);
                       
                    }  
                }else if(game.getTurnPlayable()){
                     if(!boardState1.equals(boardState2)){ 
                        System.out.println("in play set to false");
                        game.setTurnPlayable(false);
                        //game.setBoard();
                        game.setBoard2(boardState2);
                        System.out.println(game.getBoard()+ " is the changed board");
                    }
                }else{
                     //sleep(1000);
                     System.out.println("SHOULDNT GET HERE!");
                 }
               
               }catch(Exception e){
                   System.out.println(e.toString());
               }         
        }
  }
    
    public void start () {
      System.out.println("Starting " +  threadName );
      if (t == null) {
         t = new Thread (this, threadName);
         t.start ();
      }
   }
    
}

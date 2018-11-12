/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package models;

import daos.GameDao;

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
           
           if(t.getName().equals("PollThread")){
               String boardState1 = gameDao.getBoard();
               String boardState2 = gameDao.getBoard();
               
               while(boardState1.equals(boardState2)){
                   System.out.println("Here i am in thread POLLL");
                 boardState2 = gameDao.getBoard();
                 game.setTurnPlayable(false);
                }             

           }else if(t.getName().equals("PlayThread")){
               String boardState1 = gameDao.getBoard();
               String boardState2 = gameDao.getBoard();
               
               while(boardState1.equals(boardState2)){
                 boardState2 = gameDao.getBoard();
                    System.out.println("Here i am in thread PLAY");
                 game.setTurnPlayable(true);
                }   
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

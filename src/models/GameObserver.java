/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package models;

/**
 *
 * @author windows
 */
public class GameObserver extends Observer {

   
     static boolean gameInProgress;
     static boolean turnPlayable;
     Game game;
     
     public GameObserver(Game game){
         this.game = game;
         this.game.attach(this);
     }
    
    
    @Override
    public void update() {
         this.turnPlayable = game.getTurnPlayable();
    }
    
    public boolean getTurn(){
        return this.turnPlayable;
    }
    
}

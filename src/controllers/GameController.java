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
    
    public void buttonAction(int x, int y){
        //pollDb();
        if(game.getGameOver()==false){
            String result = gameDao.checkSquare(x, y, game.getGameId());
            System.out.println("result is: "+result);
            System.out.println("turnPlauable is "+game.getTurnPlayable());
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
    
    public void setBoardView(){
        //pollDb();
        if(game.getGameOver()==false){
            if(!game.getBoard().equals("ERROR-NOMOVES")){
                String[] moves = gameDao.getBoard().split("\\s*\n\\s*");
                for(int i=0; i<moves.length;i++){
                    String [] movesDetails = moves[i].split("\\s*,\\s*");
                    int playerId = Integer.parseInt(movesDetails[0]);
                    String x = movesDetails[1];
                    String y = movesDetails[2];
                    String tempSymbol = "";

                     if(playerId==game.getUserId()){
                         tempSymbol=game.getPlayerSymbol();
                     }else{
                         tempSymbol=game.getOpponentSymbol();
                     }

                    if(x.equals("0")&&y.equals("0")){
                        System.out.println("setting view to "+ tempSymbol);
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
    public void updateBoardView(){
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
    
    public void waitTurn(){  
       checkWin();
       if(waitForTurn()==1){
          announceWinner();
          
       }
    }
    
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

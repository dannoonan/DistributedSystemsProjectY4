/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package daos;

import ttt.james.server.TTTWebService;
import ttt.james.server.TTTWebService_Service;

/**
 *
 * @author windows
 */
public class GameDao {
    
    int userId;
    int gameId;
    
   TTTWebService proxy;
   TTTWebService_Service link = new TTTWebService_Service();
   
   public GameDao(){
        proxy = link.getTTTWebServicePort();
   }
   
   public GameDao(int uid, int gid){
       this.userId = uid;
       this.gameId = gid;
        proxy = link.getTTTWebServicePort();
    }
   
   public String getGames(){
       String returnString = proxy.showOpenGames();
      // System.out.println("retstring = "+ returnString + "hello");
       return returnString;
       
   }
   public String addGame(int uid){
       String retString= proxy.newGame(uid);
       //System.out.println("retstring = "+ retString + "hello");
       return retString;
       
   }
   public String joinGame(int uid, int gid){
       String retString= proxy.joinGame(uid, gid);
       //System.out.println("retstring = "+ retString + "hello");
       return retString;
       
   }
  public String getLeagueTable(){
       String retString= proxy.leagueTable();
       
       return retString;
  }
  
  public String getGameState(){
      String retStr = proxy.getGameState(gameId);
      
      
      return retStr;
  }
  public void setGameState(int gState){
      proxy.setGameState(gameId,gState);
  }
  
  public String checkSquare(int x, int y, int gid){
      
      String retString = proxy.checkSquare(x, y, gid);
      
      return retString;
  }
  
  public String takeSquare(int x, int y, int gid, int pid){
      //API IS WRONG HERE. BELOW PID AND GID IN RIGHT SPOTS
      String retString = proxy.takeSquare(x, y, pid, gid);
      
      return retString;
  }
  
  public String getBoard(){
      //API IS WRONG HERE. BELOW PID AND GID IN RIGHT SPOTS
      String retString = proxy.getBoard(this.gameId);
      //System.out.print("gID is : "+this.gameId);
      //System.out.print("retString is : "+retString);
      return retString;
  }
  public String checkWin(){
      
      String retString = proxy.checkWin(this.gameId);
      if(retString.equals("ERROR-NOMOVES")){
          retString="0";
      }
      return retString;
  }
  public String showAllMyGames(){
      String retStr = proxy.showAllMyGames(userId);
      return retStr;
  }
  
   
}

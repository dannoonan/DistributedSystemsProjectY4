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
    
   TTTWebService proxy;
   TTTWebService_Service link = new TTTWebService_Service();
   
   public GameDao(){
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
   
}

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
public class UserDao {
    
    TTTWebService proxy;
    TTTWebService_Service link = new TTTWebService_Service();
    
    public UserDao(){
        proxy = link.getTTTWebServicePort();
    }
    
    public String register(String username, String password, String name, String surname) {
       String returnString = "";
       
       returnString = proxy.register(username, password, name, surname);
        
       return returnString;
    }
     public int login(String username, String password){
        int returnInt =0;
        returnInt = proxy.login(username, password);
       // System.out.println("Test - "+ returnInt);
        return returnInt;
        
    }
}

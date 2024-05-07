/**
This application is for demonstration use only. It contains known application security
vulnerabilities that were created expressly for demonstrating the functionality of
application security testing tools. These vulnerabilities may present risks to the
technical environment in which the application is installed. You must delete and
uninstall this demonstration application upon completion of the demonstration for
which it is intended. 

IBM DISCLAIMS ALL LIABILITY OF ANY KIND RESULTING FROM YOUR USE OF THE APPLICATION
OR YOUR FAILURE TO DELETE THE APPLICATION FROM YOUR ENVIRONMENT UPON COMPLETION OF
A DEMONSTRATION. IT IS YOUR RESPONSIBILITY TO DETERMINE IF THE PROGRAM IS APPROPRIATE
OR SAFE FOR YOUR TECHNICAL ENVIRONMENT. NEVER INSTALL THE APPLICATION IN A PRODUCTION
ENVIRONMENT. YOU ACKNOWLEDGE AND ACCEPT ALL RISKS ASSOCIATED WITH THE USE OF THE APPLICATION.

IBM AltoroJ
(c) Copyright IBM Corp. 2008, 2013 All Rights Reserved.
 */
package com.ibm.security.appscan.altoromutual.servlet;

import java.io.IOException;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;

import javax.servlet.ServletException;
import javax.servlet.http.Cookie;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

import com.ibm.security.appscan.Log4AltoroJ;
import com.ibm.security.appscan.altoromutual.util.DBUtil;
import com.ibm.security.appscan.altoromutual.util.ServletUtil;

public class LoginServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    public LoginServlet() {
        super();
    }

    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        HttpSession session = request.getSession(false);
        if (session != null) {
            session.removeAttribute(ServletUtil.SESSION_ATTR_USER);
        }
        response.sendRedirect("index.jsp");
    }

    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        HttpSession session = request.getSession(true);

        String username = request.getParameter("uid");
        String password = request.getParameter("passw");

        // Validate input parameters
        if (username == null || username.trim().isEmpty() || password == null || password.trim().isEmpty()) {
            // Invalid input
            request.getSession(true).setAttribute("loginError", "Username or password cannot be empty.");
            response.sendRedirect("login.jsp");
            return;
        }

        username = username.trim().toLowerCase(); // Sanitize username
        password = password.trim(); // No need to convert to lowercase
        
        // Use parameterized query to prevent SQL injection
        try {
            if (!isValidUser(username, password)) {
                Log4AltoroJ.getInstance().logError("Login failed >>> User: " + username);
                throw new Exception("Login Failed: We're sorry, but this username or password was not found in our system. Please try again.");
            }

            // Handle the cookie using ServletUtil.establishSession(String)
            try {
                Cookie accountCookie = ServletUtil.establishSession(username, session);
                response.addCookie(accountCookie);
                response.sendRedirect(request.getContextPath() + "/bank/main.jsp");
            } catch (Exception ex) {
                ex.printStackTrace();
                response.sendError(500);
            }
        } catch (Exception ex) {
            request.getSession(true).setAttribute("loginError", ex.getLocalizedMessage());
            response.sendRedirect("login.jsp");
        }
    }

    // Validate user credentials using parameterized query
    private boolean isValidUser(String username, String password) throws SQLException {
        String query = "SELECT COUNT(*) FROM users WHERE username = ? AND password = ?";
        try (PreparedStatement statement = DBUtil.getConnection().prepareStatement(query)) {
            statement.setString(1, username);
            statement.setString(2, password);
            try (ResultSet resultSet = statement.executeQuery()) {
                if (resultSet.next()) {
                    int count = resultSet.getInt(1);
                    return count > 0;
                }
            }
        }
        return false;
    }
}

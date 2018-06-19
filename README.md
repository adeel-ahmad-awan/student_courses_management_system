### Entities

*   **Roles**

    *   Roles can be admin, student and teacher

*   **User**

    *   user with role admin

        *   have all rights

        *   can enable or disable users, courses or subjects

    *   user with role teacher

        *   can create courses and add or delete subjects in courses

        *   will have full CRUD permission on Course and Subjects

    *   user with role student

        *   can adopt at max 1 course at a time

        *   can only ( see (view), search, add ) subject of the course he adopted

*   **Courses**

    *   1 course can have minimum 3 and maximum 5 subjects

*   **subjects**

#### other requirements

1.  User listing for admin will be different i.e student listing and teacher listing

2.  add proper filters on all listings for admin only i.e courses with most adopted subject with most use in courses teacher with coerces etc

3.  HINT : login & register feature must be implemented

4.  maintain count of record in all entities i.e (Courses, subjects)

#### My requirements

1.  404 error page.
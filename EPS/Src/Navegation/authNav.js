import { createNativeStackNavigator } from "@react-navigation/native-stack";
import Login from "../../screens/Auth/login";
import Register from "../../screens/Auth/register";

const Stack = createNativeStackNavigator();

export default function AuthNav() {
  return (
    <Stack.Navigator initialRouteName="Login">
      <Stack.Screen
        name="Login"
        component={Login}
        options={{ headerShown: false }}
      />
      <Stack.Screen name="Register" component={Register} />
    </Stack.Navigator>
  );
}
